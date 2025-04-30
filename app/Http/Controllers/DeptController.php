<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DeptController extends Controller
{
    public function index()
    {
        $department = Department::all();
        return view('department.department', [
            'departments' => $department
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255'
        ]);

        department::create([
            'department' => $validated['department_name']
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data departemen');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255'
        ]);

        $department = department::findOrFail($id);
        $department->update([
            'department' => $validated['department_name']
        ]);

        return redirect()->back()->with('success', 'Data departemen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $department = department::findOrFail($id);
        $department->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}