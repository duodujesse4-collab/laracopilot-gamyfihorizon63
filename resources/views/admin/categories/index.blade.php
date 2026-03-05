@extends('layouts.admin')
@section('title', 'Categories - Admin')
@section('page-title', 'Categories')
@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-gray-800">All Categories</h2>
            <p class="text-sm text-gray-500">{{ $categories->total() }} categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-2">
            <i class="fas fa-plus text-sm"></i> Add Category
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Category</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Slug</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-500 font-medium">Products</th>
                    <th class="text-right px-5 py-3 text-xs text-gray-500 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            @else
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-tag text-emerald-600 text-sm"></i>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $category->name }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($category->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $category->slug }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full">{{ $category->products_count }} products</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-800 mr-3 text-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 border-t border-gray-100">{{ $categories->links() }}</div>
</div>
@endsection
