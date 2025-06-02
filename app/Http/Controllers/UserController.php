<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Plant;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['department', 'plant'])->get();
        $departments = Department::all();
        $plant = Plant::all();
        $role = Role::all();
        return view('user.user', [
            'users' => $user,
            'departments' => $departments,
            'plants' => $plant,
            'roles' => $role
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_username' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_department' => 'required|string|exists:department,uuid',
            'user_plant' => 'required|string|exists:plant,uuid',
            'user_role' => 'required|string|exists:role,uuid'
        ]);

        $user = User::create([
            'username' => $request->user_username,
            'name' => $request->user_name,
            'email' => $request->user_email,
            'role_uuid' => $request->user_role,
            'plant_uuid' => $request->user_plant,
            'dept_uuid' => $request->user_department,
            'password' => Hash::make('cpi12345')
        ]);

        $user->assignRole($request->role);

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationValidationException::withMessages([
                'current_password' => 'password lama salah',
            ]);
        }

        $user->update([
            'password' => hash::make($request->new_password),
        ]);

        return redirect()->back();
    }

    public function destroy($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $user->delete();

        return redirect()->back();
    }
}