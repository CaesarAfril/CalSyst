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
}
