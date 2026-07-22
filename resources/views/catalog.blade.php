@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
<div class="bg-white min-h-screen pt-12 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 border-b border-slate-100 pb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900 tracking-tight">Catalog</h1>
                <p class="text-slate-500 mt-2 text-sm">{{ $products->total() }} products available</p>
            </div>
            
            {{-- Mobile Filter Toggle --}}
            <button class="mt-4 md:mt-0 lg:hidden inline-flex items-center space-x-2 px-4 py-2 border border-slate-200 rounded-full text-slate-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                <span>Filters</span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            {{-- Sidebar Filters --}}
            <aside class="hidden lg:block lg:w-64 flex-shrink-0">
                <div class="sticky top-28">
                    {{-- Search --}}
                    <form method="GET" action="{{ route('catalog') }}" class="mb-10">
                        <label class="block text-sm font-medium text-slate-900 mb-3">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-0 pr-4 py-2 bg-transparent border-0 border-b border-slate-200 focus:ring-0 focus:border-rose-500 text-sm transition-colors text-slate-700 placeholder-slate-400">
                        </div>
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                    </form>

                    {{-- Categories --}}
                    <div class="mb-10">
                        <h3 class="text-sm font-medium text-slate-900 mb-4">Categories</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('catalog', array_merge(request()->except('category'), [])) }}" class="text-sm transition-colors {{ !request('category') ? 'text-rose-500 font-medium' : 'text-slate-500 hover:text-slate-900' }}">
                                    All Categories
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('catalog', array_merge(request()->except('category'), ['category' => $category->slug])) }}" class="text-sm transition-colors {{ request('category') === $category->slug ? 'text-rose-500 font-medium' : 'text-slate-500 hover:text-slate-900' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Sort --}}
                    <div>
                        <h3 class="text-sm font-medium text-slate-900 mb-4">Sort By</h3>
                        <ul class="space-y-3">
                            @foreach(['newest' => 'Newest Arrivals', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low', 'name' => 'Name: A-Z'] as $key => $label)
                                <li>
                                    <a href="{{ route('catalog', array_merge(request()->except('sort'), ['sort' => $key])) }}" class="text-sm transition-colors {{ request('sort') === $key ? 'text-rose-500 font-medium' : 'text-slate-500 hover:text-slate-900' }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- Product Grid --}}
            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 gap-y-12">
                        @foreach($products as $product)
                            <div class="group flex flex-col">
                                <a href="{{ route('product.show', $product->slug) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-50 mb-4 rounded-lg block">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                                    @else
                                        <div class="flex items-center justify-center h-full text-slate-300 text-sm">No Image</div>
                                    @endif
                                    
                                    {{-- Status Badges --}}
                                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                                        @if($product->stock <= 0)
                                            <span class="bg-slate-900 text-white text-[10px] uppercase tracking-wider font-semibold px-2 py-1 rounded-sm">Sold Out</span>
                                        @elseif($product->stock < 10)
                                            <span class="bg-rose-100 text-rose-700 text-[10px] uppercase tracking-wider font-semibold px-2 py-1 rounded-sm">Low Stock</span>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="flex flex-col flex-grow">
                                    <div class="flex justify-between items-start mb-1">
                                        <a href="{{ route('product.show', $product->slug) }}" class="block pr-4">
                                            <h3 class="font-medium text-slate-900 group-hover:text-rose-500 transition-colors text-base line-clamp-1">{{ $product->name }}</h3>
                                        </a>
                                        <span class="font-medium text-slate-900 whitespace-nowrap">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <span class="text-sm text-slate-500 mb-3">{{ $product->category->name }}</span>
                                    
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full py-2.5 border border-slate-200 text-slate-900 text-sm font-medium rounded-full hover:border-rose-500 hover:text-rose-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-16 border-t border-slate-100 pt-8 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-32">
                        <h3 class="text-xl font-medium text-slate-900 tracking-tight mb-2">No products found</h3>
                        <p class="text-slate-500">We couldn't find anything matching your current filters.</p>
                        <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center mt-6 px-6 py-2 border border-slate-200 rounded-full text-sm font-medium text-slate-700 hover:border-rose-500 hover:text-rose-500 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
