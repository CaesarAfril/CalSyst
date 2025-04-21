<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\Department;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Assets::with([
            'department',
            'plant',
            'category',
            'latest_external_calibration',
            'latest_temp_calibration',
            'latest_display_calibration'
        ])->get();

        $plant = Plant::all();
        $category = Category::all();
        $department = Department::all();
        return view('asset.asset', [
            'assets' => $assets,
            'categories' => $category,
            'departments' => $department,
            'plants' => $plant
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
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('csv_file'), 'r');
        $header = fgetcsv($file);

        $file = fopen($request->file('csv_file'), 'r');
        $header = fgetcsv($file, 0, ';');

        while ($row = fgetcsv($file, 0, ';')) {
            $data = array_combine($header, $row);

            $plant = Plant::where('plant', $data['plant'])->firstOrFail();
            $department = Department::where('department', $data['departemen'])->firstOrFail();
            $category = Category::where('category', $data['kategori'])->where('calibration', $data['kalibrasi'])->firstOrFail();

            $rawDate = $data['expired_date'];
            $formattedDate = null;

            try {
                $formattedDate = \Carbon\Carbon::createFromFormat('Y/m/d', $rawDate)->format('Y-m-d');
            } catch (\Exception $e1) {
                try {
                    $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $rawDate)->format('Y-m-d');
                } catch (\Exception $e2) {
                    $formattedDate = null;
                }
            }

            $resolution = str_replace(',', '.', $data['resolusi']);
            $correction = str_replace(',', '.', $data['koreksi']);
            $uncertainty = str_replace(',', '.', $data['ketidakpastian']);
            $standard = str_replace(',', '.', $data['standar']);
            Assets::create([
                'plant_uuid' => $plant->uuid,
                'dept_uuid' => $department->uuid,
                'location' => $data['lokasi'],
                'category_uuid' => $category->uuid,
                'merk' => $data['merk'],
                'type' => $data['tipe'],
                'series_number' => $data['nomor_seri'],
                'capacity' => $data['kapasitas'],
                'range' => $data['range'],
                'resolution' => floatval($resolution),
                'correction' => floatval($correction),
                'uncertainty' => floatval($uncertainty),
                'standard' => floatval($standard),
                'expired_date' => $formattedDate,
            ]);
            DB::listen(function ($query) {
                dump($query->sql);
                dump($query->bindings);
            });
        }

        fclose($file);
        return back()->with('success', 'Import CSV berhasil');
    }
}
