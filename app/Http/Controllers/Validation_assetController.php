<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Plant;
use App\Models\Validation_asset;
use Illuminate\Http\Request;

class Validation_assetController extends Controller
{
    public function index()
    {
        $assets = Validation_asset::with([
            'department',
            'plant'
        ])->get();

        $plant = Plant::all();
        $department = Department::all();
        return view('asset.validation_asset', [
            'assets' => $assets,
            'departments' => $department,
            'plants' => $plant
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'asset_department' => 'required|string|exists:department,uuid',
            'asset_plant' => 'required|string|exists:plant,uuid',
            'asset_location' => 'required|string|max:255',
            'asset_machine_name' => 'required|string|max:255',
            'asset_detail' => 'required|string|max:255'
        ];

        $validated = $request->validate($rules);

        Validation_asset::create([
            'plant_uuid' => $validated['asset_plant'],
            'dept_uuid' => $validated['asset_department'],
            'location' => $validated['asset_location'],
            'machine_name' => $validated['asset_machine_name'],
            'detail' => $validated['asset_detail']
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $asset = Validation_asset::findOrFail($id);
        $asset->delete();

        return redirect()->back();
    }
}
