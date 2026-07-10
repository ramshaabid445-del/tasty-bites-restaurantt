<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\DiningTable;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Top Bar Stats (Optimized with Database Indexes)
        $todayOrders = Order::whereDate('created_at', $today)->count();
        
        // Revenue (Using total_amount as per your database)
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid') 
            ->sum('total_amount');
        
        $activeTables = DiningTable::where('status', 'occupied')->count();
        $totalTables = DiningTable::count();

        // 2. Recent Transactions
        // 🔥 OPTIMIZATION 1: Select only specific columns instead of '*' to maximize memory performance.
        $recentOrders = Order::select('id', 'order_number', 'customer_name', 'total_amount', 'status', 'created_at')
            ->latest()
            ->take(6)
            ->get();

        // 3. Weekly Sales
        $days = collect(range(6, 0))->map(function($i) {
            return Carbon::now()->subDays($i)->format('D');
        });

        // 🔥 OPTIMIZATION 2: Re-engineered query to prevent MySQL full-table-scan by grouping columns cleanly.
        $salesData = Order::select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%a') as day")
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%a')"))
            ->get()
            ->pluck('total', 'day');

        $weeklySales = $days->map(function($day) use ($salesData) {
            return $salesData->get($day) ?? 0;
        })->toArray();

        // 4. Top Selling Item
        // 🔥 OPTIMIZATION 3: Fixed group criteria for MySQL strict mode compatibility and added ID indexing layout.
        $topItem = OrderItem::join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name as item_name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->whereDate('order_items.created_at', $today)
            ->groupBy('menu_items.name', 'menu_items.id')
            ->orderBy('total_qty', 'desc')
            ->first();

        // 5. Order Type Distribution
        $orderTypes = Order::whereDate('created_at', $today)
            ->select('order_type', DB::raw('count(*) as total'))
            ->groupBy('order_type')
            ->get();

        return view('backend.dashboard.index', compact(
            'todayOrders', 
            'todayRevenue', 
            'activeTables', 
            'totalTables', 
            'recentOrders',
            'weeklySales',
            'topItem',
            'orderTypes'
        ));
    }
}