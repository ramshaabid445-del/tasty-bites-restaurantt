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

    /**
     * Nayi Table banane ka view dikhana (Missing Method)
     */
    public function create()
    {
        return view('backend.tables.create');
    }

    public function floorPlans()
    {
        $tables = DiningTable::all();
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
            'status' => 'available', 
        ]);

        // Agar aap alag 'create' page se aa rahe hain toh index par bhejien
        return redirect()->route('admin.tables.index')->with('success', 'Table added successfully!');
    }

    /**
     * Table update karne ka view dikhana (Missing Method)
     */
    public function edit($id)
    {
        $table = DiningTable::findOrFail($id);
        return view('backend.tables.edit', compact('table'));
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

        return redirect()->route('admin.tables.index')->with('success', 'Table updated successfully!');
    }

    public function destroy($id)
    {
        $diningTable = DiningTable::findOrFail($id);
        $diningTable->delete();
        return redirect()->back()->with('success', 'Table deleted!');
    }
}