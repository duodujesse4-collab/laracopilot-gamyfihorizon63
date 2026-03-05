<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private function requireAuth()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        $user = User::findOrFail(session('user_id'));
        $recentOrders = Order::where('user_id', session('user_id'))->orderBy('created_at', 'desc')->take(5)->get();
        return view('account.index', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        $orders = Order::where('user_id', session('user_id'))->orderBy('created_at', 'desc')->paginate(10);
        return view('account.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        $order = Order::with('items.product')->where('user_id', session('user_id'))->findOrFail($id);
        return view('account.order-detail', compact('order'));
    }

    public function profile()
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        $user = User::findOrFail(session('user_id'));
        return view('account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        $user = User::findOrFail(session('user_id'));
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        session(['user_name' => $user->name, 'user_email' => $user->email]);
        return back()->with('success', 'Profile updated successfully!');
    }
}