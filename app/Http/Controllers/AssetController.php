<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Assets;
use App\Models\Category;
use App\Models\Department;
use App\Models\Plant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Assets::fetchData($search);

        $assets = $query->paginate(10);

        return view('asset.asset', [
            'assets' => $assets,
            'categories' => Category::all(),
            'departments' => Department::all(),
            'plants' => Plant::all(),
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $category = Category::where('uuid', $request->asset_category)->first();

        $rules = [
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
            'plant_uuid' => $validated['asset_plant'] ?? Auth::user()->plant->plant_uuid,
            'dept_uuid' => $validated['asset_department'] ?? Auth::user()->dept_uuid,
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
        $header = fgetcsv($file, 0, ';');

        while ($row = fgetcsv($file, 0, ';')) {
            $data = array_combine($header, $row);

            // Find related models safely
            $plant = Plant::where('plant', $data['Plant'])->firstOrFail();
            $department = Department::where('department', $data['Departemen'])->firstOrFail();
            $category = Category::where('category', $data['Kategori'])->where('calibration', $data['Pelaksana'])->firstOrFail();
            $rawDate = $data['Expired'];
            $formattedDate = $rawDate ?? null;

            if (!empty($rawDate) && !Carbon::hasFormat($rawDate, 'Y-m-d')) {
                if (Carbon::hasFormat($rawDate, 'Y/m/d')) {
                    $formattedDate = Carbon::createFromFormat('Y/m/d', $rawDate)->format('Y-m-d');
                } elseif (Carbon::hasFormat($rawDate, 'd/m/Y')) {
                    $formattedDate = Carbon::createFromFormat('d/m/Y', $rawDate)->format('Y-m-d');
                }
            }

            $capacity = mb_convert_encoding($data['Kapasitas'], 'UTF-8', 'Windows-1252');
            $resolution = str_replace(',', '.', $data['Resolusi']);
            $correction = str_replace(',', '.', $data['Koreksi']);
            $uncertainty = str_replace(',', '.', $data['Ketidakpastian']);
            $standard = str_replace(',', '.', $data['Standar']);

            Assets::create([
                'plant_uuid' => $plant->uuid,
                'dept_uuid' => $department->uuid,
                'location' => $data['Lokasi'],
                'category_uuid' => $category->uuid,
                'merk' => $data['Merk'],
                'type' => $data['Tipe'],
                'series_number' => $data['Nomor Seri'],
                'capacity' => $capacity,
                'range' => $data['Range'],
                'resolution' => floatval($resolution),
                'correction' => floatval($correction),
                'uncertainty' => floatval($uncertainty),
                'standard' => floatval($standard),
                'expired_date' => $formattedDate,
            ]);
        }

        fclose($file);
        return redirect()->back()->with('success', 'CSV imported successfully.');
    }


    public function exportExcelAssets()
    {
        return Excel::download(new UsersExport, 'Assets.xlsx');
    }
}
