@extends('layouts.admin')
@section('title', 'Edit Category - Admin')
@section('page-title', 'Edit Category')
@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('name') border-red-500 @enderror" required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('description', $category->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                <input type="url" name="image_url" value="{{ old('image_url', $category->image_url) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-200 transition font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
