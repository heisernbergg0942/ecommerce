@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Account</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Profile --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-amber-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <h2 class="font-semibold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('account.profile') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" value="{{ auth()->user()->address }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg font-medium text-sm transition">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order History --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Order History</h2>

                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="font-semibold text-gray-900">Order #{{ $order->id }}</span>
                                        <span class="text-sm text-gray-500 ml-2">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="text-sm px-3 py-1 rounded-full font-medium
                                        @if($order->status === 'delivered') bg-green-100 text-green-700
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                        @else bg-yellow-100 text-yellow-700
                                        @endif
                                    ">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="space-y-2">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                            <span class="text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="border-t mt-3 pt-3 flex justify-between">
                                    <span class="text-sm text-gray-500">Shipping: {{ $order->shipping_address }}, {{ $order->shipping_city }}</span>
                                    <span class="font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No orders yet.</p>
                        <a href="{{ route('catalog') }}" class="text-amber-600 hover:text-amber-700 font-medium mt-2 inline-block">Start Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
