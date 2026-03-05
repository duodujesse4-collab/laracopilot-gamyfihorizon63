<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $filter = request('filter', 'all');
        $query = Product::with('category')->orderBy('stock', 'asc');
        if ($filter === 'low') {
            $query->where('stock', '<', 10)->where('stock', '>', 0);
        } elseif ($filter === 'out') {
            $query->where('stock', 0);
        }
        $products = $query->paginate(20);
        $lowStock = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStock = Product::where('stock', 0)->count();
        return view('admin.inventory.index', compact('products', 'lowStock', 'outOfStock', 'filter'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate(['stock' => 'required|integer|min:0']);
        Product::findOrFail($id)->update(['stock' => $request->stock]);
        return redirect()->back()->with('success', 'Stock updated successfully!');
    }
}