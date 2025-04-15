<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function index()
    {
        $weights = Weight::all();

        return view('weight.weight', [
            'weights' => $weights
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mass' => 'required',
            'error' => 'required'
        ]);

        Weight::create([
            'mass' => $validated['mass'],
            'error' => $validated['error']
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'edit_mass' => 'required|string|max:255',
            'edit_error' => 'required|string|max:255',
        ]);

        $weights = Weight::findOrFail($id);
        $weights->update([
            'mass' => $validated['edit_mass'],
            'error' => $validated['edit_error'],
        ]);

        return redirect()->back();
    }
}