@extends('layouts.admin')
@section('title', 'Edit Product - Admin')
@section('page-title', 'Edit Product')
@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('name') border-red-500 @enderror" required>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('sku') border-red-500 @enderror" required>
                    @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Compare Price ($)</label>
                    <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none" required>{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600">
                        <span class="text-sm text-gray-700">Featured Product</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="active" value="1" {{ old('active', $product->active) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-200 transition font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
