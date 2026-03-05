<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }
}