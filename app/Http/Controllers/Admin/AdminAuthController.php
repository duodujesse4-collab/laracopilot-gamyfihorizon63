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
            'admin@shopify.com' => ['password' => 'admin123', 'role' => 'Super Admin', 'name' => 'Admin'],
            'manager@shopify.com' => ['password' => 'manager123', 'role' => 'Store Manager', 'name' => 'Manager'],
            'inventory@shopify.com' => ['password' => 'inventory123', 'role' => 'Inventory Manager', 'name' => 'Inventory']
        ];

        if (isset($credentials[$request->email]) &&
            $credentials[$request->email]['password'] === $request->password) {
            session([
                'admin_logged_in' => true,
                'admin_user' => $credentials[$request->email]['name'],
                'admin_email' => $request->email,
                'admin_role' => $credentials[$request->email]['role']
            ]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials. Please check the demo credentials below.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email', 'admin_role']);
        return redirect()->route('admin.login');
    }
}