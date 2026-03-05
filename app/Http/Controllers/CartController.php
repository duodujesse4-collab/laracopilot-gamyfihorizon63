<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1']);
        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }
        $cart = session()->get('cart', []);
        $rowId = 'product_' . $product->id;
        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] += $request->quantity;
        } else {
            $cart[$rowId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => $request->quantity,
                'slug' => $product->slug,
            ];
        }
        session()->put('cart', $cart);
        return back()->with('success', $product->name . ' added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate(['rowId' => 'required', 'quantity' => 'required|integer|min:1']);
        $cart = session()->get('cart', []);
        if (isset($cart[$request->rowId])) {
            $cart[$request->rowId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Cart updated!');
    }

    public function remove($rowId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$rowId]);
        session()->put('cart', $cart);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}