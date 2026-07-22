<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index()
    {
        // Get all completed/paid orders (assuming 'delivered' or 'processing' implies paid, or just not cancelled)
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        
        $totalRevenue = Order::whereIn('status', $validStatuses)->sum('total_price');
        
        $thisMonthRevenue = Order::whereIn('status', $validStatuses)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');
            
        $lastMonthRevenue = Order::whereIn('status', $validStatuses)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_price');
            
        // Calculate growth percentage
        $growth = 0;
        if ($lastMonthRevenue > 0) {
            $growth = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($thisMonthRevenue > 0) {
            $growth = 100;
        }

        // Recent paid orders
        $recentOrders = Order::with('user')
            ->whereIn('status', $validStatuses)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.revenue.index', compact(
            'totalRevenue', 
            'thisMonthRevenue', 
            'lastMonthRevenue',
            'growth',
            'recentOrders'
        ));
    }
}
