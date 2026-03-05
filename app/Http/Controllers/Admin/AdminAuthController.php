<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'admin@shopify.com' => ['password' => 'admin123', 'name' => 'Admin', 'role' => 'Super Admin'],
            'manager@shopify.com' => ['password' => 'manager123', 'name' => 'Manager', 'role' => 'Store Manager'],
            'inventory@shopify.com' => ['password' => 'inventory123', 'name' => 'Inventory', 'role' => 'Inventory Manager'],
        ];

        if (isset($credentials[$request->email]) &&
            $credentials[$request->email]['password'] === $request->password) {
            session([
                'admin_logged_in' => true,
                'admin_user' => $credentials[$request->email]['name'],
                'admin_email' => $request->email,
                'admin_role' => $credentials[$request->email]['role'],
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials. Please check the test accounts below.']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login');
    }
}