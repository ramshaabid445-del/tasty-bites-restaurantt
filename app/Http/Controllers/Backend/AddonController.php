<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::latest()->get();
        return view('backend.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('backend.addons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons,name',
            'price' => 'required|numeric|min:0',
        ]);

        Addon::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.addons.index')->with('success', 'Addon created successfully!');
    }

    public function edit(Addon $addon)
    {
        return view('backend.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons,name,' . $addon->id,
            'price' => 'required|numeric|min:0',
        ]);

        $addon->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.addons.index')->with('success', 'Addon updated successfully!');
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();
        return redirect()->route('admin.addons.index')->with('success', 'Addon deleted successfully!');
    }
}