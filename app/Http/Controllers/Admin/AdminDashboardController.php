<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        $lowStockProducts = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(8)->get();
        $topProducts = Product::orderBy('sales_count', 'desc')->take(5)->get();
        $monthlyRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total');
        $todayOrders = Order::whereDate('created_at', today())->count();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalUsers',
            'pendingOrders', 'processingOrders', 'completedOrders',
            'lowStockProducts', 'outOfStockProducts', 'recentOrders',
            'topProducts', 'monthlyRevenue', 'todayOrders'
        ));
    }
}