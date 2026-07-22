@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('catalog') }}" class="hover:text-amber-600">Catalog</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-amber-600">{{ $product->category->name }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    {{-- Product Detail --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        {{-- Image --}}
        <div class="bg-gray-100 rounded-2xl aspect-square overflow-hidden">
            @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full">
                    <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <span class="text-sm text-amber-600 font-medium">{{ $product->category->name }}</span>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
            <div class="flex items-center space-x-4 mt-4">
                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if($product->stock > 0)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">In Stock ({{ $product->stock }})</span>
                @else
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Out of Stock</span>
                @endif
            </div>

            <p class="text-gray-600 mt-6 leading-relaxed">{{ $product->description }}</p>

            {{-- Add to Cart --}}
            @auth
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add') }}" class="mt-8">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)" class="px-4 py-2 text-gray-600 hover:text-gray-900">-</button>
                                <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-x border-gray-300 py-2">
                                <button type="button" onclick="document.getElementById('qty').value = Math.min({{ $product->stock }}, parseInt(document.getElementById('qty').value) + 1)" class="px-4 py-2 text-gray-600 hover:text-gray-900">+</button>
                            </div>
                            <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-semibold transition transform hover:scale-105 flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </form>
                @endif
            @else
                <div class="mt-8">
                    <a href="{{ route('login') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-lg font-semibold transition">Login to Add to Cart</a>
                </div>
            @endauth

            {{-- Product Meta --}}
            <div class="mt-8 border-t pt-6 space-y-3">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Quality guaranteed with manufacturer warranty
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Fast delivery across Cambodia
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    30-day return policy
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('product.show', $related->slug) }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            @if($related->image)
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-amber-600 transition text-sm">{{ $related->name }}</h3>
                            <span class="text-lg font-bold text-gray-900 mt-2 block">${{ number_format($related->price, 2) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
