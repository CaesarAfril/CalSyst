<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machine = Machine::all();
        return view('machine.machine', [
            'machines' => $machine
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'machine_name' => 'required|string|max:255'
        ]);

        Machine::create([
            'machine_name' => $validated['machine_name']
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $machine = Machine::findOrFail('uuid', $id);
        $machine->delete();

        return redirect()->back();
    }
}
