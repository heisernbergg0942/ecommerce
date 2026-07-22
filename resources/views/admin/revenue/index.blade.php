@extends('layouts.admin')

@section('title', 'Revenue Control')
@section('page-title', 'Revenue Control')

@section('content')
<div class="space-y-6">
    
    {{-- Revenue Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Revenue</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalRevenue, 2) }}</p>
            <p class="text-sm text-gray-400 mt-1">All time sales</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Month</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($thisMonthRevenue, 2) }}</p>
            
            <div class="flex items-center mt-2">
                @if($growth > 0)
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-500">+{{ number_format($growth, 1) }}%</span>
                @elseif($growth < 0)
                    <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                    <span class="text-sm font-medium text-red-500">{{ number_format($growth, 1) }}%</span>
                @else
                    <span class="text-sm font-medium text-gray-500">0.0%</span>
                @endif
                <span class="text-sm text-gray-400 ml-2">vs last month</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Month</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($lastMonthRevenue, 2) }}</p>
            <p class="text-sm text-gray-400 mt-1">Previous 30 days</p>
        </div>
    </div>

    {{-- Recent Paid Orders --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Recent Revenue Transactions</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">View All Orders</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                        <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 text-sm font-medium text-gray-900">
                                <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-amber-600">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $order->user->name }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-600">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : 
                                      ($order->status === 'shipped' ? 'bg-blue-100 text-blue-700' : 
                                      ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm font-semibold text-gray-900">
                                ${{ number_format($order->total_price, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No recent transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
