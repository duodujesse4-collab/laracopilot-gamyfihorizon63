<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('featured', true)->where('active', true)->with('category')->take(8)->get();
        $categories = Category::withCount('products')->take(6)->get();
        $newArrivals = Product::where('active', true)->orderBy('created_at', 'desc')->take(8)->get();
        $bestSellers = Product::where('active', true)->orderBy('sales_count', 'desc')->take(4)->get();
        return view('shop.home', compact('featuredProducts', 'categories', 'newArrivals', 'bestSellers'));
    }

    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('category');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        $sortBy = $request->get('sort', 'newest');
        match($sortBy) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('sales_count', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        return view('shop.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('active', true)->with('category')->firstOrFail();
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->take(4)->get();
        return view('shop.show', compact('product', 'related'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('active', true)
            ->paginate(12);
        return view('shop.category', compact('category', 'products'));
    }
}