@extends('layouts.admin')

@section('title', 'Order #' . $order->id)
@section('page-title', 'Order #' . $order->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Order Details --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-4 py-3">Product</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-4 py-3">Price</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-4 py-3">Qty</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->product->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-900">Total</td>
                            <td class="px-4 py-3 font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Shipping Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Address</span>
                    <p class="text-gray-900 font-medium">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <span class="text-gray-500">City</span>
                    <p class="text-gray-900 font-medium">{{ $order->shipping_city }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Phone</span>
                    <p class="text-gray-900 font-medium">{{ $order->shipping_phone }}</p>
                </div>
                @if($order->notes)
                    <div>
                        <span class="text-gray-500">Notes</span>
                        <p class="text-gray-900 font-medium">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Order Status --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h2>
            <div class="mb-4">
                <span class="text-sm px-3 py-1 rounded-full font-medium
                    @if($order->status === 'delivered') bg-green-100 text-green-700
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                    @else bg-yellow-100 text-yellow-700
                    @endif
                ">{{ ucfirst($order->status) }}</span>
            </div>

            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                @csrf
                @method('PUT')
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Update Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg font-medium text-sm transition">
                        Update Status
                    </button>
                </div>
            </form>

            <div class="mt-6 space-y-3 text-sm border-t pt-4">
                <div>
                    <span class="text-gray-500">Customer</span>
                    <p class="text-gray-900 font-medium">{{ $order->user->name }}</p>
                    <p class="text-gray-500">{{ $order->user->email }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Order Date</span>
                    <p class="text-gray-900 font-medium">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="mt-6 block text-center text-gray-600 hover:text-gray-800 font-medium text-sm">
                Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection
