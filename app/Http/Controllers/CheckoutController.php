<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $subtotal = $total;
        $shipping = $total > 100 ? 0 : 9.99;
        $tax = round($total * 0.08, 2);
        $grandTotal = $subtotal + $shipping + $tax;
        return view('shop.checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'grandTotal'));
    }

    public function process(Request $request)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:credit_card,paypal,stripe,bank_transfer',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $shipping = $subtotal > 100 ? 0 : 9.99;
        $tax = round($subtotal * 0.08, 2);
        $total = $subtotal + $shipping + $tax;

        $order = Order::create([
            'user_id' => session('user_id'),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'shipping_name' => $request->first_name . ' ' . $request->last_name,
            'shipping_email' => $request->email,
            'shipping_phone' => $request->phone,
            'shipping_address' => $request->address,
            'shipping_city' => $request->city,
            'shipping_state' => $request->state,
            'shipping_zip' => $request->zip,
            'shipping_country' => $request->country,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
            Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            Product::where('id', $item['product_id'])->increment('sales_count', $item['quantity']);
        }

        session()->forget('cart');
        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($orderId);
        return view('shop.checkout-success', compact('order'));
    }
}