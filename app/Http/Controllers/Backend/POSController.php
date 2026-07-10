<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\DiningTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TaxSetting; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    // 1. POS Main Screen
    public function index()
    {
        // Optimized asset loading for POS view layer cards
        $categories = Category::select('id', 'name')->get();
        
        $menuItems = MenuItem::with(['category' => function($q) {
                $q->select('id', 'name');
            }])
            ->select('id', 'category_id', 'name', 'price', 'image', 'is_available')
            ->where('is_available', true) 
            ->latest()
            ->get(); 
            
        $tables = DiningTable::select('id', 'name', 'status')->get(); 

        return view('backend.pos.index', compact('categories', 'menuItems', 'tables'));
    }

    // 2. Save Order 
    public function storeOrder(Request $request)
    {
        // Validation parameters matching frontend submission keys
        $request->validate([
            'cart_data' => 'required',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'payment_method' => 'required|in:cash,card,online',
            'table_id' => 'required_if:order_type,dine_in|nullable|integer',
        ]);

        // 🔥 FIX 1: Safe JS payload processing array formatting extraction
        $cart = json_decode($request->cart_data, true);

        if(!is_array($cart) || count($cart) === 0) {
            return back()->with('error', 'Your cart is completely empty!');
        }

        $taxConfig = TaxSetting::where('is_active', true)->first();
        $taxPercentage = $taxConfig ? $taxConfig->tax_rate : 0;

        DB::beginTransaction();
        
        try {
            $subTotal = 0;
            foreach($cart as $item) {
                $subTotal += ($item['price'] * $item['quantity']);
            }
            
            $taxAmount = ($subTotal * $taxPercentage) / 100; 
            $grandTotal = $subTotal + $taxAmount;

            // Generation of completely clean relational billing record
            $order = Order::create([
                'order_number'    => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'         => Auth::id() ?? 1,
                'customer_name'   => $request->customer_name ?? 'Walk-in Guest',
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

            // Generating batch row items mapping context fields
            foreach($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $item['id'],
                    'item_name'    => $item['name'] ?? 'Menu Item', 
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['price'],
                    'sub_total'    => $item['price'] * $item['quantity'],
                    'price'        => $item['price'], 
                ]);
            }

            // Lock structural dining tables metrics to prevent dual-orders
            if($request->order_type == 'dine_in' && $request->table_id) {
                DiningTable::where('id', $request->table_id)->update(['status' => 'occupied']);
            }

            DB::commit();

            // Redirect context returning stream seamlessly directly inside printing loops
            return redirect()->route('admin.pos.invoice', $order->id)->with('success', 'Order Placed Successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Database Transaction Failed: ' . $e->getMessage());
        }
    }

    // 3. Show Invoice 
    public function showInvoice($id)
    {
        $order = Order::with(['items.menuItem', 'table'])->findOrFail($id);
        return view('backend.pos.invoice', compact('order'));
    }

    // 4. Order History
    public function orderHistory()
    {
        $orders = Order::select('id', 'order_number', 'customer_name', 'customer_phone', 'total_amount', 'status', 'payment_method', 'dining_table_id', 'user_id', 'created_at', 'order_type')
            ->with([
                'table' => function($q) { $q->select('id', 'name'); },
                'user'  => function($q) { $q->select('id', 'name'); }
            ])
            ->latest()
            ->paginate(15);
            
        // 🔥 NOTICE: Uses backend/orders/index or backend/pos/orders based on structural filename bindings
        return view('backend.orders.index', compact('orders'));
    }

    // 5. Update Status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        $order = Order::findOrFail($id);
        
        $updateData = ['status' => $request->status];
        
        // Dynamic assignment validations checks mapping incoming requests keys
        if($request->has('assigned_staff_id') && $request->assigned_staff_id != null) {
            $updateData['user_id'] = $request->assigned_staff_id; 
        }

        $order->update($updateData);

        // 🔥 FIX 2: Automatic conditional release loops for associated table allocations
        if($order->dining_table_id) {
            if(in_array($request->status, ['completed', 'cancelled'])) {
                DiningTable::where('id', $order->dining_table_id)->update(['status' => 'available']);
            }
        }

        return back()->with('success', 'Order state updated successfully!');
    }
}