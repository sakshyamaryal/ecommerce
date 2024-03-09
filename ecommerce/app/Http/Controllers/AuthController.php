<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // dd($request->all());

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role_id == 1) {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/');
            }

        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        User::create($validatedData);

        return redirect('/login')->with('success', 'User created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // This will invalidate the user's session

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
