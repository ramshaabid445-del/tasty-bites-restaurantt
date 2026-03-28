<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = DiningTable::latest()->get();
        return view('backend.tables.index', compact('tables'));
    }

    // Floor Plans wala view jo aapne sidebar mein mangha tha
    public function floorPlans()
    {
        $tables = DiningTable::all();
        // Alag alag floors ke liye data group kar sakte hain agar column ho
        return view('backend.tables.floor_plans', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:dining_tables,name',
            'capacity' => 'required|integer|min:1',
        ]);

        DiningTable::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => 'available', // Default status
        ]);

        return redirect()->back()->with('success', 'Table added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:dining_tables,name,' . $id,
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,reserved'
        ]);

        $diningTable = DiningTable::findOrFail($id);
        $diningTable->update($request->all());

        return redirect()->back()->with('success', 'Table updated successfully!');
    }

    public function destroy($id)
    {
        $diningTable = DiningTable::findOrFail($id);
        $diningTable->delete();
        return redirect()->back()->with('success', 'Table deleted!');
    }
}