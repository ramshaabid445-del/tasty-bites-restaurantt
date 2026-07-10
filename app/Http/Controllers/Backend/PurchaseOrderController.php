<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the purchase orders.
     */
    public function index() 
    {
        $orders = PurchaseOrder::with('supplier')->latest()->get();
        return view('backend.inventory.purchase-orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new purchase order.
     */
    public function create() 
    {
        $suppliers = Supplier::where('status', 1)->get();
        $materials = RawMaterial::all();
        
        // Generating Unique PO Number
        $po_number = 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        return view('backend.inventory.purchase-orders.create', compact('suppliers', 'materials', 'po_number'));
    }

    /**
     * Store a newly created purchase order in storage.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'po_number'    => 'required|unique:purchase_orders,po_number',
            'supplier_id'  => 'required|exists:suppliers,id',
            'order_date'   => 'required|date',
            'total_amount' => 'required|numeric',
            'items'        => 'required|array|min:1',
        ], [
            'supplier_id.required' => 'Please select a supplier.',
            'items.required'       => 'Please add at least one item.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Save Master Purchase Order
            $order = PurchaseOrder::create([
                'po_number'    => $request->po_number,
                'supplier_id'  => $request->supplier_id,
                'order_date'   => $request->order_date,
                'total_amount' => $request->total_amount,
                'status'       => 'pending', 
                'notes'        => $request->notes,
            ]);

            // 2. Note: Agar aapka items table (detail) alag hai toh yahan loop chalega.
            // Filhal master record commit kar rahe hain.

            DB::commit();

            $notification = [
                'message' => 'Purchase Order Created Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('admin.inventory.purchase-orders.index')->with($notification);

        } catch (\Exception $e) {
            DB::rollback();
            
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
            
            return back()->withInput()->with($notification);
        }
    }

    /**
     * Display the specified purchase order.
     */
    public function show($id) 
    {
        $order = PurchaseOrder::with(['supplier'])->findOrFail($id);
        return view('backend.inventory.purchase-orders.show', compact('order'));
    }

    /**
     * Show the form for editing the purchase order.
     */
    public function edit($id) 
    {
        $order = PurchaseOrder::findOrFail($id);
        $suppliers = Supplier::where('status', 1)->get();
        $materials = RawMaterial::all();
        
        return view('backend.inventory.purchase-orders.edit', compact('order', 'suppliers', 'materials'));
    }

    /**
     * Update the specified purchase order in storage.
     */
    public function update(Request $request, $id) 
    {
        $order = PurchaseOrder::findOrFail($id);
        
        $request->validate([
            'supplier_id'  => 'required|exists:suppliers,id',
            'order_date'   => 'required|date',
            'total_amount' => 'required|numeric',
        ]);

        $order->update([
            'supplier_id'  => $request->supplier_id,
            'order_date'   => $request->order_date,
            'total_amount' => $request->total_amount,
            'notes'        => $request->notes,
            'status'       => $request->status ?? $order->status,
        ]);

        return redirect()->route('admin.inventory.purchase-orders.index')->with([
            'message' => 'Purchase Order Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified purchase order from storage.
     */
    public function destroy($id) 
    {
        $order = PurchaseOrder::findOrFail($id);
        $order->delete();

        return back()->with([
            'message' => 'Purchase Order Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
}