<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KDSController extends Controller
{
    // 1. Kitchen Screen: Sirf wo orders dikhana jo abhi tak serve nahi hue
    public function index()
    {
        $orders = Order::with('items.menuItem')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderBy('created_at', 'asc') // Purane orders pehle aayenge (First-In, First-Out)
            ->get();

        return view('backend.kds.index', compact('orders'));
    }

    // 2. Status Update Logic: Chef status change karega
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:preparing,ready,served,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        // Agar order serve ho gaya hai aur dine-in tha, toh table ko free karne ki logic bhi daal sakte hain
        // Lekin professional POS mein table "Completed" ya "Paid" par free hoti hai.

        return response()->json([
            'success' => true, 
            'message' => 'Order status updated to ' . $request->status
        ]);
    }
}
