<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function purchaseOrders()
{
    // Ye line file ko dhoond kar screen par dikhayegi
    return view('backend.inventory.purchase_orders');
}

public function wastageLog()
{
    return view('backend.inventory.wastage_log');
}
public function toggleStatus($id)
{
    $item = MenuItem::findOrFail($id);
    // 1 ko 0 kar do, 0 ko 1
    $item->status = $item->status == 1 ? 0 : 1;
    $item->save();

    return back()->with('success', 'Status updated successfully!');
}
}
