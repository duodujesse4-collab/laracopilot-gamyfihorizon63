<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('stock', 0)->count();
        $totalCustomers = Customer::count();
        $recentOrders = Order::with('customer')->orderBy('created_at', 'desc')->limit(8)->get();
        $topProducts = Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->limit(5)->get();
        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $newCustomersThisMonth = Customer::whereMonth('created_at', now()->month)->count();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'pendingOrders', 'processingOrders',
            'totalProducts', 'lowStockProducts', 'outOfStock', 'totalCustomers',
            'recentOrders', 'topProducts', 'revenueThisMonth', 'ordersThisMonth',
            'newCustomersThisMonth'
        ));
    }
}