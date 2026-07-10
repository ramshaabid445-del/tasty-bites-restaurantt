<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DiningTable; 
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->total_amount = $request->total_amount;
            $order->tax_amount = $request->tax_amount ?? 0;
            $order->payment_method = $request->payment_method ?? 'cash';
            $order->order_type = $request->order_type ?? 'dine_in';
            $order->table_id = $request->table_id;
            $order->status = $request->status ?? 'pending'; 
            $order->customer_name = $request->customer_name;
            $order->customer_phone = $request->customer_phone;
            $order->save();

            if($request->has('items')) {
                foreach ($request->items as $item) {
                    $data = [
                        'order_id' => $order->id,
                        'menu_item_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    if (Schema::hasColumn('order_items', 'price')) {
                        $data['price'] = $item['price'];
                    } elseif (Schema::hasColumn('order_items', 'unit_price')) {
                        $data['unit_price'] = $item['price'];
                    }

                    if (Schema::hasColumn('order_items', 'sub_total')) {
                        $data['sub_total'] = $item['price'] * $item['quantity'];
                    }

                    DB::table('order_items')->insert($data);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Order placed successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function live() 
    { 
        return view('backend.orders.live'); 
    }

    public function history() 
    {
        $orders = Order::select('id', 'order_number', 'order_type', 'customer_name', 'customer_phone', 'payment_method', 'total_amount', 'status', 'created_at')
            ->with(['items' => function($q) {
                $q->select('id', 'order_id', 'menu_item_id', 'quantity');
            }, 'table' => function($q) {
                $q->select('id', 'name');
            }])
            ->latest()
            ->paginate(15);
            
        return view('backend.orders.index', compact('orders'));
    }

    public function dispatchList() 
    {
        $orders = Order::select('id', 'order_number', 'order_type', 'customer_name', 'customer_phone', 'status', 'created_at')
            ->addSelect(Schema::hasColumn('orders', 'table_id') ? 'table_id' : (Schema::hasColumn('orders', 'dining_table_id') ? 'dining_table_id as table_id' : 'id'))
            ->with([
                'table' => function($q) { $q->select('id', 'name'); }
            ])
            ->whereIn('status', ['ready', 'cooking', 'processing', 'pending']) 
            ->latest()
            ->get();
            
        $staff = Employee::select('id', 'name', 'designation')->get(); 
        
        return view('backend.orders.dispatch', compact('orders', 'staff'));
    }

    public function show($id) 
    {
        $order = Order::with([
            'table' => function($q) { $q->select('id', 'name'); },
            'items' => function($q) {
                $q->select('*'); 
            }
        ])->findOrFail($id);
        
        return view('backend.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id) 
    {
        try {
            // Find order or return safe error JSON format
            $order = Order::find($id);
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID #' . $id . ' not found in system database.'
                ], 404);
            }

            // 1. Explicit state change
            $order->status = 'completed';

            // 2. Dynamic column check strategy (Eliminates HTTP 500 execution crashes)
            if (Schema::hasColumn('orders', 'assigned_staff_id')) {
                $order->assigned_staff_id = $request->assigned_staff_id;
            } elseif (Schema::hasColumn('orders', 'staff_id')) {
                $order->staff_id = $request->assigned_staff_id;
            } elseif (Schema::hasColumn('orders', 'rider_id')) {
                $order->rider_id = $request->assigned_staff_id;
            } elseif (Schema::hasColumn('orders', 'user_id')) {
                $order->user_id = $request->assigned_staff_id;
            } else {
                // Fallback logging if table structure lacks relation definitions
                Log::warning("Order #{$id} dispatched but schema lacks employee structural columns.");
            }

            $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Order routed and assigned successfully!'
            ]);

        } catch (\Exception $e) {
            // Guarantees plain JSON layout instead of framework rendering full HTML exception views
            return response()->json([
                'success' => false,
                'message' => 'Internal Processing Error: ' . $e->getMessage()
            ], 500);
        }
    }
}