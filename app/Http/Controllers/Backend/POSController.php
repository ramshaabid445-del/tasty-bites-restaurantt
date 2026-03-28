<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\DiningTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TaxSetting; // <--- Yeh lazmi hai dynamic tax ke liye
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    // 1. POS Main Screen
    public function index()
    {
        $categories = Category::all();
        $menuItems = MenuItem::with('category')->latest()->get(); 
        $tables = DiningTable::all(); 

        return view('backend.pos.index', compact('categories', 'menuItems', 'tables'));
    }

    // 2. Save Order from POS (Updated with Dynamic Tax)
    public function storeOrder(Request $request)
    {
        $request->validate([
            'cart_data' => 'required',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $cart = json_decode($request->cart_data, true);

        if(empty($cart)) {
            return back()->with('error', 'Your cart is empty!');
        }

        // --- DYNAMIC TAX LOGIC START ---
        $taxConfig = TaxSetting::first();
        // Agar tax active hai toh rate uthao, warna 0 kardo
        $taxPercentage = ($taxConfig && $taxConfig->is_active) ? $taxConfig->tax_rate : 0;
        // --- DYNAMIC TAX LOGIC END ---

        DB::beginTransaction();
        
        try {
            $subTotal = 0;
            foreach($cart as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }
            
            // Calculation based on your Database Settings
            $taxAmount = ($subTotal * $taxPercentage) / 100; 
            $grandTotal = $subTotal + $taxAmount;

            $order = Order::create([
                'order_number'    => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'         => Auth::id() ?? 1,
                'customer_name'   => $request->customer_name,
                'customer_phone'  => $request->customer_phone,
                'dining_table_id' => $request->order_type == 'dine_in' ? $request->table_id : null,
                'order_type'      => $request->order_type,
                'sub_total'       => $subTotal,
                'tax_amount'      => $taxAmount, 
                'total_amount'    => $grandTotal,
                'payment_method'  => $request->payment_method,
                'payment_status'  => 'paid', 
                'status'          => 'pending', 
            ]);

            foreach($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $item['id'],
                    'item_name'    => $item['name'] ?? 'Item', 
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['price'],
                    'sub_total'    => $item['price'] * $item['quantity'],
                ]);
            }

            if($request->order_type == 'dine_in' && $request->table_id) {
                DiningTable::where('id', $request->table_id)->update(['status' => 'occupied']);
            }

            DB::commit();
            return redirect()->route('admin.pos.invoice', $order->id)->with('success', 'Order Placed Successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 3. Show Invoice
    public function showInvoice($id)
    {
        $order = Order::with(['items', 'table'])->findOrFail($id);
        return view('backend.pos.invoice', compact('order'));
    }

    // 4. Order History
    public function orderHistory()
    {
        $orders = Order::with(['table', 'user'])->latest()->paginate(15);
        return view('backend.pos.orders', compact('orders'));
    }

    // 5. Update Status (Pending to Served/Completed)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required']);
        
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        if($request->status == 'completed' && $order->dining_table_id) {
            DiningTable::where('id', $order->dining_table_id)->update(['status' => 'available']);
        }

        return back()->with('success', 'Order status updated!');
    }
}