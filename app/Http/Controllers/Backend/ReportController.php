<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // 🔥 FIXED: Added missing Schema facade import to prevent quick action crash

class ReportController extends Controller
{
    /**
     * Daily Sales Report Logic
     */
    public function dailySales(Request $request) 
    {
        $date = Carbon::parse($request->get('date', date('Y-m-d')));
        $statuses = ['pending', 'preparing', 'served', 'completed', 'dispatched'];

        // 🔥 OPTIMIZATION 1: High-efficiency DB level aggregate calculations in a single query
        $dbStats = Order::whereDate('created_at', $date)
            ->whereIn('status', $statuses)
            ->selectRaw('SUM(total_amount) as total_sales, COUNT(id) as total_orders, SUM(tax_amount) as total_tax')
            ->first();

        $stats = (object)[
            'total_sales'  => $dbStats->total_sales ?? 0,
            'total_orders' => $dbStats->total_orders ?? 0,
            'total_tax'    => $dbStats->total_tax ?? 0
        ];

        // For compatibility with your view's exact variable name
        $total_revenue = $stats->total_sales;        

        // 🔥 OPTIMIZATION 2: Only select required columns and use pagination for the report table
        $orders = Order::select('id', 'order_number', 'customer_name', 'total_amount', 'tax_amount', 'status', 'created_at')
            ->whereDate('created_at', $date)
            ->whereIn('status', $statuses)
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Filter date parameter ko pagination ke links mein maintain rakhega

        // Payment Methods breakdown (Optimized group query using indexes)
        $payments = Order::whereDate('created_at', $date)
            ->whereIn('status', ['completed', 'served'])
            ->selectRaw('payment_method, SUM(total_amount) as amount')
            ->groupBy('payment_method')
            ->get();

        // Best Sellers for the day (Optimized raw queries with specific columns)
        $bestSellers = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select(
                'menu_items.name as item_name', 
                DB::raw('SUM(order_items.quantity) as qty'), 
                DB::raw('SUM(menu_items.price * order_items.quantity) as total')
            )
            ->whereDate('orders.created_at', $date)
            ->whereIn('orders.status', ['completed', 'served'])
            ->groupBy('menu_items.name', 'menu_items.id') // Grouping with ID for strict sql_mode compatibility
            ->orderBy('qty', 'desc')
            ->take(5)
            ->get();

        return view('backend.management.reports.daily_sales', compact('orders', 'stats', 'payments', 'bestSellers', 'date', 'total_revenue'));
    }

    /**
     * Best Sellers All Time Report
     */
    public function bestSellers() 
    {
        // 🔥 OPTIMIZATION 3: All time statistics optimized with faster DB grouping
        $bestSellers = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select(
                'menu_items.name as item_name', 
                DB::raw('SUM(order_items.quantity) as qty'), 
                DB::raw('SUM(menu_items.price * order_items.quantity) as amount')
            )
            ->whereIn('orders.status', ['completed', 'served', 'dispatched'])
            ->groupBy('menu_items.name', 'menu_items.id')
            ->orderBy('qty', 'desc')
            ->take(10)
            ->get();

        return view('backend.management.reports.best_sellers', compact('bestSellers'));
    }

    /**
     * Stock / Inventory Report
     */
    public function stockReport() 
    {
        // 🔥 OPTIMIZATION 4: Eager loading to sync smoothly with your summary statistics cards
        $items = MenuItem::with(['category' => function($query) {
                $query->select('id', 'name'); 
            }])
            ->select('id', 'category_id', 'name', 'price', 'status', 'created_at') // Blade view requires status tracking matching database schema checks
            ->latest()
            ->get(); // Using get() to ensure count summaries don't break with pagination wrappers
            
        return view('backend.management.reports.stock', compact('items'));
    }

    /**
     * Toggle MenuItem Availability (Stock Switch)
     */
    public function toggleStatus($id)
    {
        $item = MenuItem::findOrFail($id);
        
        // 🔥 DEHAAN SE FIX: Priority always goes to 'status' column because Blade depends on it
        if (Schema::hasColumn('menu_items', 'status')) {
            // Direct safe 1 and 0 inversion switch
            $item->status = ($item->status == 1) ? 0 : 1;
            
            // Backup sync: Agar data table mein dono columns parallel chal rahe hon
            if (Schema::hasColumn('menu_items', 'is_available')) {
                $item->is_available = ($item->status == 1) ? 1 : 0;
            }
        } 
        // Fallback agar sirf 'is_available' column database mein functional ho
        elseif (Schema::hasColumn('menu_items', 'is_available')) {
            $item->is_available = !$item->is_available;
            $item->status = $item->is_available ? 1 : 0;
        } 
        // Safety execution block
        else {
            $item->status = ($item->status == 1) ? 0 : 1;
        }
        
        $item->save();

        return back()->with('success', 'Stock status updated successfully!');
    }
}