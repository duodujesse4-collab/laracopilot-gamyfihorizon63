@extends('layouts.admin')
@section('title', 'Orders - Admin')
@section('page-title', 'Orders')
@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-5 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">All Orders</h2>
        <p class="text-sm text-gray-500">{{ $orders->total() }} total orders</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Order #</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Customer</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Date</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Payment</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-500 font-medium">Status</th>
                    <th class="text-right px-5 py-3 text-xs text-gray-500 font-medium">Total</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-500 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                @php
                    $colors = ['pending' => 'yellow', 'processing' => 'blue', 'shipped' => 'indigo', 'delivered' => 'green', 'cancelled' => 'red'];
                    $color = $colors[$order->status] ?? 'gray';
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-sm font-medium text-emerald-600">{{ $order->order_number }}</td>
                    <td class="px-5 py-3">
                        <p class="text-sm text-gray-800">{{ $order->user ? $order->user->name : 'Guest' }}</p>
                        <p class="text-xs text-gray-400">{{ $order->shipping_email }}</p>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-700">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right text-sm font-semibold">${{ number_format($order->total, 2) }}</td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-emerald-600 hover:text-emerald-800 text-sm"><i class="fas fa-eye"></i> View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-100">{{ $orders->links() }}</div>
</div>
@endsection
