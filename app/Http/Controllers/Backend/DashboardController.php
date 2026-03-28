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

        // 1. Top Bar Stats
        $todayOrders = Order::whereDate('created_at', $today)->count();
        
        // Revenue (Using total_amount as per your database)
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid') 
            ->sum('total_amount');
        
        $activeTables = DiningTable::where('status', 'occupied')->count();
        $totalTables = DiningTable::count();

        // 2. Recent Transactions
        $recentOrders = Order::latest()->take(6)->get();

        // 3. Weekly Sales
        $days = collect(range(6, 0))->map(function($i) {
            return Carbon::now()->subDays($i)->format('D');
        });

        $salesData = Order::select(
                DB::raw('SUM(total_amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%a') as day")
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->get()
            ->pluck('total', 'day');

        $weeklySales = $days->map(function($day) use ($salesData) {
            return $salesData->get($day) ?? 0;
        })->toArray();

        // 4. Top Selling Item (Fix: Migration chhere baghair join lagaya hai)
        $topItem = OrderItem::join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.name as item_name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->whereDate('order_items.created_at', $today)
            ->groupBy('menu_items.name')
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