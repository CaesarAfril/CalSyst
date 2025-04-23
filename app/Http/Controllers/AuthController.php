<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function actionLogin(Request $request)
    {
        $login = $request->input('email'); // or 'login' if you rename the input field
        $password = $request->input('password');

        // Determine if login is an email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Build the credentials array
        $credentials = [
            $field => $login,
            'password' => $password,
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        } else {
            Session::flash('error', 'Email/Username atau password salah');
            return redirect('/');
        }
    }

    public function actionLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}