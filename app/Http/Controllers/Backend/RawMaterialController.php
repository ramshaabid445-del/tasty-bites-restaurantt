<?php

namespace App\Http\Controllers\Backend; // <--- Yeh line confirm karein

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index()
    {
        $materials = RawMaterial::latest()->get();
        return view('backend.inventory.raw-materials.index', compact('materials'));
    }

    public function create()
    {
        return view('backend.inventory.raw-materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required',
            'quantity' => 'required|numeric',
            'alert_quantity' => 'required|numeric',
        ]);

        RawMaterial::create($request->all());

        return redirect()->route('admin.inventory.raw-materials.index')->with('success', 'Material added successfully!');
    }
}