<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DiningTable; // Aapka model DiningTable hai
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Order History (Saare purane orders ki list)
     * Route: admin.orders.history
     */
    public function history()
    {
        // Items ke saath saare orders fetch karein
        $orders = Order::with('items')->latest()->paginate(15);
        
        // Aapki history file ka path (folder: orders, file: history.blade.php)
        return view('backend.orders.history', compact('orders'));
    }

    /**
     * Invoice View (Single Order ki detail aur print)
     * Route: admin.orders.show
     */
    public function show($id)
    {
        // Order fetch karein aur uske items + table relation load karein
        $order = Order::with(['items', 'table'])->findOrFail($id);
        
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Live Orders (Kitchen Display ya Active orders ke liye)
     * Route: admin.orders.live
     */
    public function live() 
    {
        // Filhal sirf view load ho raha hai
        return view('backend.orders.live'); 
    }

    /**
     * Dispatch List (Delivery/Takeaway ready orders ke liye)
     * Route: admin.orders.dispatch
     */
    public function dispatchList() 
    {
        // Filhal sirf view load ho raha hai
        return view('backend.orders.dispatch'); 
    }
}