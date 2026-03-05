<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $categories = Category::withCount('products')->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);
        $validated['slug'] = Str::slug($request->name);
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);
        $validated['slug'] = Str::slug($request->name);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with products.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}