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

        return redirect()->back()->with('success', 'Berhasil menambah data mesin');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'edit_machine_name' => 'required|string|max:255'
        ]);

        $machine = Machine::findOrFail($id);
        $machine->update([
            'machine_name' => $validated['edit_machine_name']
        ]);

        return redirect()->back()->with('success', 'Data Alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $machine = Machine::findOrFail('uuid', $id);
        $machine->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}