<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
   public function index() {
    $orders = \App\Models\PurchaseOrder::with('supplier')->latest()->get();
    
    // Folder ka naam 'purchase-orders' hai (dash ke saath)
    return view('backend.inventory.purchase-orders.index', compact('orders'));
}
    public function create() {
        $suppliers = Supplier::where('status', 1)->get();
        $materials = RawMaterial::all();
        // Unique PO Number generate ho raha hai
        $po_number = 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        return view('backend.inventory.purchase-orders.create', compact('suppliers', 'materials', 'po_number'));
    }

    public function store(Request $request) {
        // 1. Validation: Check karo sab sahi hai ya nahi
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        // 2. Data Save: Database mein entry insert karo
        PurchaseOrder::insert([
            'po_number' => $request->po_number,
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'total_amount' => $request->total_amount,
            'status' => $request->status, // e.g., Pending, Received
            'notes' => $request->notes,
            'created_at' => Carbon::now(),
        ]);

        // 3. Redirect: Wapas index page par bhejo notification ke saath
        $notification = array(
            'message' => 'Purchase Order Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.inventory.purchase-orders.index')->with($notification);
    }
}