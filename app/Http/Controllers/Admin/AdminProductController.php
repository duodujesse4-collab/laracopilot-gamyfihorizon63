<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku',
            'image_url' => 'nullable|url',
            'featured' => 'boolean',
            'active' => 'boolean',
        ]);
        $validated['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        $validated['featured'] = $request->boolean('featured');
        $validated['active'] = $request->boolean('active', true);
        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'image_url' => 'nullable|url',
            'featured' => 'boolean',
            'active' => 'boolean',
        ]);
        $validated['featured'] = $request->boolean('featured');
        $validated['active'] = $request->boolean('active', true);
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}