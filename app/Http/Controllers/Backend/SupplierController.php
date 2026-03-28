<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // 1. Display all suppliers
    public function index() {
        $suppliers = Supplier::latest()->get();
        return view('backend.inventory.suppliers.index', compact('suppliers'));
    }

    // 2. Show create form
    public function create() {
        return view('backend.inventory.suppliers.create');
    }

    // 3. Store new supplier (Updated with all fields)
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name'            => 'required|string|max:255',
            'company_name'    => 'nullable|string|max:255',
            'phone'           => 'required|string|max:20', 
            'email'           => 'nullable|email|max:255',
            'address'         => 'nullable|string',
            'opening_balance' => 'required|numeric|min:0',
            'status'          => 'nullable|boolean',
        ]);

        // Status checkbox handle karna (agar form se nahi aaya toh default active/1)
        $validatedData['status'] = $request->has('status') ? 1 : 0;

        Supplier::create($validatedData);

        return redirect()->route('admin.inventory.suppliers.index')
                         ->with('success', 'Supplier onboarded successfully!');
    }

    // 4. Edit (Optional: Abhi views nahi hain lekin route ready hai)
    public function edit(Supplier $supplier) {
        return view('backend.inventory.suppliers.edit', compact('supplier'));
    }
}