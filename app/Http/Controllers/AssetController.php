<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\Department;
use App\Models\Plant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Assets::with([
            'department',
            'plant',
            'category',
            'latest_external_calibration',
            'latest_temp_calibration',
            'latest_display_calibration'
        ]);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('series_number', 'like', "%{$search}%")
                    ->orWhere('capacity', 'like', "%{$search}%")
                    ->orWhere('range', 'like', "%{$search}%")
                    ->orWhere('resolution', 'like', "%{$search}%")
                    ->orWhere('correction', 'like', "%{$search}%")
                    ->orWhere('uncertainty', 'like', "%{$search}%")
                    ->orWhere('standard', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('expired_date', 'like', "%{$search}%");
            })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category', 'like', "%{$search}%");
                })
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('department', 'like', "%{$search}%");
                })
                ->orWhereHas('plant', function ($q) use ($search) {
                    $q->where('plant', 'like', "%{$search}%");
                });
        }

        $assets = $query->paginate(10);

        return view('asset.asset', [
            'assets' => $assets,
            'categories' => Category::all(),
            'departments' => Department::all(),
            'plants' => Plant::all(),
            'search' => $search, // Kirim ke view agar form tetap terisi
        ]);
    }

    public function store(Request $request)
    {
        $category = Category::where('uuid', $request->asset_category)->first();

        $rules = [
            'asset_department' => 'required|string|exists:department,uuid',
            'asset_plant' => 'required|string|exists:plant,uuid',
            'asset_location' => 'required|string|max:255',
            'asset_category' => 'required|string|exists:category,uuid',
            'asset_merk' => 'required|string|max:255',
            'asset_type' => 'required|string|max:255',
            'asset_series_number' => 'required|string|max:255',
        ];

        if ($category && $category->calibration === 'Internal') {
            $rules = array_merge($rules, [
                'asset_capacity' => 'required|string|max:255',
                'asset_range' => 'required|string|max:255',
                'asset_resolution' => 'required|string|max:255',
                'asset_correction' => 'required|string|max:255',
                'asset_uncertainty' => 'required|string|max:255',
                'asset_standard' => 'required|numeric|regex:/^\d{1,5}(\.\d{1,3})?$/',
            ]);
        }

        $validated = $request->validate($rules);

        Assets::create([
            'plant_uuid' => $validated['asset_plant'],
            'dept_uuid' => $validated['asset_department'],
            'location' => $validated['asset_location'],
            'category_uuid' => $validated['asset_category'],
            'merk' => $validated['asset_merk'],
            'type' => $validated['asset_type'],
            'series_number' => $validated['asset_series_number'],
            'capacity' => $validated['asset_capacity'] ?? NULL,
            'range' => $validated['asset_range'] ?? NULL,
            'resolution' => $validated['asset_resolution'] ?? NULL,
            'correction' => $validated['asset_correction'] ?? NULL,
            'uncertainty' => $validated['asset_uncertainty'] ?? NULL,
            'standard' => $validated['asset_standard'] ?? NULL,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'asset_name' => 'required|string|max:255'
        ]);

        $asset = Assets::findOrFail($id);
        $asset->update([
            'asset' => $validated['asset_name']
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $asset = Assets::findOrFail($id);
        $asset->delete();

        return redirect()->back();
    }

    public function importCsv(Request $request)
    {
        try {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt'
            ]);

            $file = fopen($request->file('csv_file'), 'r');
            $header = fgetcsv($file, 0, ';');

            while ($row = fgetcsv($file, 0, ';')) {
                $data = array_combine($header, $row);

                $plant = Plant::where('plant', $data['plant'])->firstOrFail();
                $department = Department::where('department', $data['departemen'])->firstOrFail();
                $category = Category::where('category', $data['kategori'])->where('calibration', $data['kalibrasi'])->firstOrFail();

                $rawDate = $data['expired_date'];
                $formattedDate = $rawDate ?? null;

                $capacity = mb_convert_encoding($data['kapasitas'], 'UTF-8', 'Windows-1252');

                if (!empty($rawDate) && !Carbon::hasFormat($rawDate, 'Y-m-d')) {
                    if (Carbon::hasFormat($rawDate, 'Y/m/d')) {
                        $formattedDate = Carbon::createFromFormat('Y/m/d', $rawDate)->format('Y-m-d');
                    } elseif (Carbon::hasFormat($rawDate, 'd/m/Y')) {
                        $formattedDate = Carbon::createFromFormat('d/m/Y', $rawDate)->format('Y-m-d');
                    } else {
                        $formattedDate = $rawDate;
                    }
                }

                $resolution = str_replace(',', '.', $data['resolusi']);
                $correction = str_replace(',', '.', $data['koreksi']);
                $uncertainty = str_replace(',', '.', $data['ketidakpastian']);
                $standard = str_replace(',', '.', $data['standar']);
                // dd($formattedDate);
                Assets::create([
                    'plant_uuid' => $plant->uuid,
                    'dept_uuid' => $department->uuid,
                    'location' => $data['lokasi'],
                    'category_uuid' => $category->uuid,
                    'merk' => $data['merk'],
                    'type' => $data['tipe'],
                    'series_number' => $data['nomor_seri'],
                    'capacity' => $capacity,
                    'range' => $data['range'],
                    'resolution' => floatval($resolution),
                    'correction' => floatval($correction),
                    'uncertainty' => floatval($uncertainty),
                    'standard' => floatval($standard),
                    'expired_date' => $formattedDate,
                ]);
            }

            fclose($file);
            return back()->with('success', 'Import CSV berhasil');
        } catch (\Exception $e) {
            dd($e); // This will dump the error and stop execution
        }
    }
}