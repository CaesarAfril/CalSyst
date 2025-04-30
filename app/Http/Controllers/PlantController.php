<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        $plant = Plant::all();
        return view('plant.plant', [
            'plants' => $plant
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'plant_name' => 'required|string|max:255',
            'plant_abbreviaton' => 'required|string|max:255',

        ]);


        Plant::create([
            'plant' => $validated['plant_name'],
            'abbreviaton' => $validated['plant_abbreviaton'],
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data Plant');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'plant_name' => 'required|string|max:255',
            'plant_abbreviaton' => 'required|string|max:255'
        ]);

        $plant = Plant::findOrFail($id);
        $plant->update([
            'plant' => $validated['plant_name'],
            'abbreviaton' => $validated['plant_abbreviaton'],
        ]);

        return redirect()->back()->with('success', 'Data plant berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}