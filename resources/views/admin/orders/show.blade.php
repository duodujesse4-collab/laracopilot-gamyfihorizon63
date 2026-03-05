@extends('layouts.admin')
@section('title', 'Order Details - Admin')
@section('page-title', 'Order Details')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-500">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                @php
                    $colors = ['pending' => 'yellow', 'processing' => 'blue', 'shipped' => 'indigo', 'delivered' => 'green', 'cancelled' => 'red'];
                    $color = $colors[$order->status] ?? 'gray';
                @endphp
                <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-{{ $color }}-100 text-{{ $color }}-700">{{ ucfirst($order->status) }}</span>
            </div>

            <table class="w-full">
                <thead class="border-b border-gray-100">
                    <tr>
                        <th class="text-left py-2 text-sm text-gray-500">Product</th>
                        <th class="text-center py-2 text-sm text-gray-500">Qty</th>
                        <th class="text-right py-2 text-sm text-gray-500">Price</th>
                        <th class="text-right py-2 text-sm text-gray-500">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" class="w-10 h-10 rounded-lg object-cover">
                                @endif
                                <p class="text-sm font-medium text-gray-800">{{ $item->product_name }}</p>
                            </div>
                        </td>
                        <td class="py-3 text-center text-sm">{{ $item->quantity }}</td>
                        <td class="py-3 text-right text-sm">${{ number_format($item->price, 2) }}</td>
                        <td class="py-3 text-right text-sm font-medium">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-gray-200">
                    <tr><td colspan="3" class="pt-3 text-sm text-gray-500">Subtotal</td><td class="pt-3 text-right text-sm">${{ number_format($order->subtotal, 2) }}</td></tr>
                    <tr><td colspan="3" class="py-1 text-sm text-gray-500">Shipping</td><td class="py-1 text-right text-sm">{{ $order->shipping == 0 ? 'Free' : '$'.number_format($order->shipping, 2) }}</td></tr>
                    <tr><td colspan="3" class="py-1 text-sm text-gray-500">Tax (8%)</td><td class="py-1 text-right text-sm">${{ number_format($order->tax, 2) }}</td></tr>
                    <tr><td colspan="3" class="pt-2 font-bold text-gray-800">Total</td><td class="pt-2 text-right font-bold text-lg text-emerald-600">${{ number_format($order->total, 2) }}</td></tr>
                </tfoot>
            </table>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Update Order Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex gap-3">
                @csrf @method('PUT')
                <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700 transition">Update Status</button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Customer</h3>
            <p class="text-sm font-medium text-gray-800">{{ $order->user ? $order->user->name : 'Guest' }}</p>
            <p class="text-sm text-gray-500">{{ $order->shipping_email }}</p>
            <p class="text-sm text-gray-500">{{ $order->shipping_phone }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Shipping Address</h3>
            <p class="text-sm text-gray-700">{{ $order->shipping_name }}</p>
            <p class="text-sm text-gray-500">{{ $order->shipping_address }}</p>
            <p class="text-sm text-gray-500">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            <p class="text-sm text-gray-500">{{ $order->shipping_country }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Payment</h3>
            <p class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ ucfirst($order->payment_status) }}</span>
        </div>
    </div>
</div>
@endsection