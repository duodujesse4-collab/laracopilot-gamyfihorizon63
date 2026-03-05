<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('featured', true)->where('active', true)->with('category')->limit(8)->get();
        $categories = Category::where('active', true)->withCount('products')->get();
        $newArrivals = Product::where('active', true)->orderBy('created_at', 'desc')->limit(4)->get();
        $bestSellers = Product::where('active', true)->withCount('orderItems')->orderBy('order_items_count', 'desc')->limit(4)->get();
        return view('shop.home', compact('featuredProducts', 'categories', 'newArrivals', 'bestSellers'));
    }

    public function index()
    {
        $query = Product::where('active', true)->with('category');
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }
        if (request('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif (request('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif (request('sort') === 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }
        $products = $query->paginate(12);
        $categories = Category::where('active', true)->get();
        return view('shop.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->where('active', true)->findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('active', true)
            ->limit(4)->get();
        return view('shop.product', compact('product', 'related'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->where('active', true)->paginate(12);
        return view('shop.category', compact('category', 'products'));
    }

    public function search()
    {
        $q = request('q', '');
        $products = Product::where('active', true)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->paginate(12);
        return view('shop.search', compact('products', 'q'));
    }
}