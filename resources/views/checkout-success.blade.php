@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="bg-white min-h-screen flex items-center justify-center py-24 px-4">
    <div class="max-w-md w-full text-center">
        
        {{-- Success Icon --}}
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-semibold text-slate-900 tracking-tight mb-2">Payment Successful!</h1>
        <p class="text-slate-500 text-sm mb-8">Thank you for your order. We've received your payment and will start processing it right away.</p>

        {{-- Order Details --}}
        <div class="bg-slate-50 rounded-xl p-5 text-left mb-8 border border-slate-100">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Order Details</span>
                <span class="text-xs text-slate-400">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Status</span>
                    <span class="font-medium text-green-600 capitalize">{{ $order->status }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Payment</span>
                    <span class="font-medium text-green-600 capitalize">{{ $order->payment_status }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Ship to</span>
                    <span class="font-medium text-slate-900 text-right">{{ $order->shipping_address }}, {{ $order->shipping_city }}</span>
                </div>
                <div class="flex justify-between text-sm border-t border-slate-200 pt-2 mt-2">
                    <span class="font-semibold text-slate-900">Total Paid</span>
                    <span class="font-bold text-slate-900">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('account') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white rounded-full text-sm font-medium transition-colors">
                View My Orders
            </a>
            <a href="{{ route('catalog') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 border border-slate-200 text-slate-700 rounded-full text-sm font-medium hover:border-rose-400 hover:text-rose-500 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
