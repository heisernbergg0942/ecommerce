@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('product.show', $item->product->slug) }}" class="font-semibold text-gray-900 hover:text-amber-600 transition">{{ $item->product->name }}</a>
                            <p class="text-sm text-gray-500 mt-1">{{ $item->product->category->name }}</p>
                            <p class="text-lg font-bold text-gray-900 mt-2">${{ number_format($item->product->price, 2) }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center border border-gray-300 rounded-lg">
                                @csrf
                                <button type="button" onclick="this.parentElement.querySelector('input').value = Math.max(1, parseInt(this.parentElement.querySelector('input').value) - 1); this.parentElement.submit()" class="px-3 py-1 text-gray-600 hover:text-gray-900">-</button>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="10" onchange="this.form.submit()" class="w-12 text-center border-x border-gray-300 py-1 text-sm">
                                <button type="button" onclick="this.parentElement.querySelector('input').value = Math.min(10, parseInt(this.parentElement.querySelector('input').value) + 1); this.parentElement.submit()" class="px-3 py-1 text-gray-600 hover:text-gray-900">+</button>
                            </form>
                            <span class="font-bold text-gray-900 w-20 text-right">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="mt-6 w-full bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-semibold text-center transition block">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('catalog') }}" class="mt-3 w-full border border-gray-300 text-gray-700 hover:border-amber-500 py-3 rounded-lg font-medium text-center transition block">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-900">Your cart is empty</h3>
            <p class="text-gray-500 mt-2">Start shopping to add items to your cart.</p>
            <a href="{{ route('catalog') }}" class="inline-block mt-6 bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-lg font-semibold transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
