<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 1. Daily Sales (End of Day)
    public function dailySales() {
        $today = Carbon::today();
        $orders = Order::whereDate('created_at', $today)->where('status', 'completed')->get();
        $total_revenue = $orders->sum('total_amount');
        
        return view('backend.management.reports.daily_sales', compact('orders', 'total_revenue'));
    }

    // 2. Best Sellers (Kon sa khana sabse zyada bika)
   // app/Http\Controllers\Backend\ReportController.php

public function bestSellers() {
    // Top 10 items orders ki counting ke hisab se
    $bestSellers = MenuItem::withCount('orders')
                    ->orderBy('orders_count', 'desc')
                    ->take(10)
                    ->get();

    // Note: Blade file mein ab aap $item->orders_count use kar sakte hain
    return view('backend.reports.best-sellers', compact('bestSellers'));
}

    // 3. Stock & Inventory Report
    public function stockReport()
{
    // Variable ka naam '$items' hona chahiye kyunki Blade mein yahi use ho raha hai
    $items = MenuItem::with('category')->latest()->get(); 
    
    // Check karein ke compact mein 'items' likha hai ya nahi
    return view('backend.management.reports.stock', compact('items'));
}
}