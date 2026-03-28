<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wastage;
use App\Models\RawMaterial;
use Carbon\Carbon;
use Auth;

class WastageController extends Controller
{
    public function index()
{
    $wastages = \App\Models\Wastage::with('raw_material')->latest()->get();
    $materials = \App\Models\RawMaterial::all();

    // Pehle tumhara path 'backend.inventory.wastage_log' tha jo ghalat hai
    // Sahi path ye hai kyunki folder ka naam 'wastage' hai
    return view('backend.inventory.wastage.index', compact('wastages', 'materials'));
}
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'quantity' => 'required|numeric|min:0.1',
            'reason' => 'required|string',
        ]);

        // 2. Data Save
        Wastage::insert([
            'raw_material_id' => $request->raw_material_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
            'user_id' => Auth::id(), // Jo banda login hai uski ID
            'created_at' => Carbon::now(),
        ]);

        // 3. Notification
        $notification = array(
            'message' => 'Wastage Reported Successfully',
            'alert-type' => 'error' // Wastage hai toh red alert (error) de sakte ho
        );

        return redirect()->back()->with($notification);
    }
}