@extends('layouts.admin')
@section('title', 'Dashboard - ShopElite Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-800">${{ number_format($totalRevenue, 0) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">This month: ${{ number_format($monthlyRevenue, 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    <p class="text-xs text-blue-600 mt-1">Today: {{ $todayOrders }} orders</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Products</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
                    <p class="text-xs text-red-500 mt-1">{{ $outOfStockProducts }} out of stock</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Customers</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    <p class="text-xs text-orange-600 mt-1">Registered users</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="ml-auto text-xs text-emerald-600 hover:underline">View →</a>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-cog text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Processing</p>
                <p class="text-2xl font-bold text-blue-600">{{ $processingOrders }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Delivered</p>
                <p class="text-2xl font-bold text-green-600">{{ $completedOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-emerald-600 hover:underline">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Order</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Customer</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Status</th>
                            <th class="text-right px-5 py-3 text-xs text-gray-500 font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-sm font-medium text-emerald-600 hover:underline">{{ $order->order_number }}</a>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $order->user ? $order->user->name : 'Guest' }}</td>
                            <td class="px-5 py-3">
                                @php
                                    $colors = ['pending' => 'yellow', 'processing' => 'blue', 'shipped' => 'indigo', 'delivered' => 'green', 'cancelled' => 'red'];
                                    $color = $colors[$order->status] ?? 'gray';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-700">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-5 py-3 text-sm text-right font-semibold">${{ number_format($order->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Top Products</h3>
            </div>
            <div class="p-5 space-y-4">
                @foreach($topProducts as $product)
                <div class="flex items-center gap-3">
                    <img src="{{ $product->image_url }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->sales_count }} sold</p>
                    </div>
                    <span class="text-sm font-semibold text-emerald-600">${{ number_format($product->price, 2) }}</span>
                </div>
                @endforeach
            </div>
            <div class="p-5 border-t border-gray-100">
                @if($lowStockProducts > 0)
                <div class="bg-orange-50 rounded-lg p-3 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-orange-500 text-sm"></i>
                    <p class="text-xs text-orange-700"><strong>{{ $lowStockProducts }}</strong> products running low on stock</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
