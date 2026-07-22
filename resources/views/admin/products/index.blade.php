@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Manage Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">{{ $products->total() }} products total</p>
    <a href="{{ route('admin.products.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Add Product</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Product</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Category</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Price</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Stock</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Featured</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->stock }}</td>
                        <td class="px-6 py-4">
                            @if($product->featured)
                                <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full font-medium">Featured</span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
