<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user_logged_in')) return redirect()->route('account');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'user_logged_in' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);
            return redirect()->intended(route('account'));
        }
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function showRegister()
    {
        if (session('user_logged_in')) return redirect()->route('account');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        session([
            'user_logged_in' => true,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);
        return redirect()->route('account')->with('success', 'Welcome! Your account has been created.');
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_id', 'user_name', 'user_email']);
        return redirect()->route('home');
    }
}