<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Deal;

class DealController extends Controller
{
    /**
     * Saari deals dikhany ke liye index page
     */
    public function index() 
    {
        // Database se latest deals uthayein
        $deals = Deal::latest()->get();
        return view('backend.management.menu.deals.index', compact('deals'));
    }

    /**
     * Naya Deal banane ka form dikhana
     */
    public function create()
    {
        // Tinker ke mutabiq 'name' column fetch ho raha hai
        $items = MenuItem::all(); 
        return view('backend.management.menu.deals.create', compact('items'));
    }

    /**
     * Deal ko database mein save karna
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'item_ids' => 'required|array',
            'description' => 'nullable|string'
        ]);

        try {
            $deal = new Deal();
            $deal->name = $request->name;
            $deal->price = $request->price;
            $deal->description = $request->description;
            
            // Ensure array save ho raha hai (Model mein casts check karein)
            $deal->items = $request->item_ids; 
            $deal->save();

            return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Deal ko delete karna
     */
    public function destroy($id)
    {
        try {
            $deal = Deal::findOrFail($id);
            $deal->delete();

            // 'admin.' prefix ke saath redirect lazmi hai
            return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.deals.index')->with('error', 'Could not delete deal.');
        }
    }
}