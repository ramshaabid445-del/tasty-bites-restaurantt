<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Exception;

class KDSController extends Controller
{
    public function index()
    {
        // 'ready' orders ko list se nikal diya hai taake sirf kaam wala data show ho
        $orders = Order::with(['items', 'table'])
            ->whereIn('status', ['pending', 'preparing'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('backend.kds.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // 1. Order check karein
            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order #'.$id.' not found!'
                ], 404);
            }

            // 2. Status validate karein
            $request->validate([
                'status' => 'required|string'
            ]);

            // 3. Status update karein
            $order->status = $request->status;

            // Timestamp Logic (Sirf tab chalegi agar columns database mein hain)
            // Agar error aaye to in lines ko comment kar dein
            if ($request->status == 'preparing') {
                $order->preparing_at = now();
            } elseif ($request->status == 'ready') {
                $order->ready_at = now();
            }

            $order->save();

            return response()->json([
                'success' => true, 
                'message' => 'Order status updated successfully!'
            ]);

        } catch (Exception $e) {
            // Ye line aapko exact batayegi ke database mein kya masla hai
            return response()->json([
                'success' => false,
                'message' => 'Controller Error: ' . $e->getMessage()
            ], 500);
        }
    }
}