@extends('layouts.admin')
@section('title', 'Products - Admin')
@section('page-title', 'Products')
@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h2 class="font-semibold text-gray-800">All Products</h2>
            <p class="text-sm text-gray-500">{{ $products->total() }} products total</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-2">
            <i class="fas fa-plus text-sm"></i> Add Product
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Product</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">SKU</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Category</th>
                    <th class="text-right px-5 py-3 text-xs text-gray-500 font-medium">Price</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-500 font-medium">Stock</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-500 font-medium">Status</th>
                    <th class="text-right px-5 py-3 text-xs text-gray-500 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/48' }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($product->name, 40) }}</p>
                                @if($product->featured)<span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded">Featured</span>@endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $product->sku }}</td>
                    <td class="px-5 py-3 text-sm text-gray-600">{{ $product->category->name }}</td>
                    <td class="px-5 py-3 text-sm text-right">
                        <div class="font-semibold">${{ number_format($product->price, 2) }}</div>
                        @if($product->compare_price)<div class="text-xs text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</div>@endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-sm font-medium {{ $product->stock === 0 ? 'text-red-600' : ($product->stock < 10 ? 'text-orange-600' : 'text-gray-700') }}">{{ $product->stock }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $product->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $product->active ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 mr-3 text-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-100">{{ $products->links() }}</div>
</div>
@endsection
