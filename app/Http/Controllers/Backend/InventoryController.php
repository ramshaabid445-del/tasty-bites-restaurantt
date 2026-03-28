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
}
