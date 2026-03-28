<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MenuItemController extends Controller
{
    public function index()
    {
        // 'with' use karne se N+1 query problem nahi aati (Optimized for speed)
        $menuItems = MenuItem::with('category')->latest()->get();
        return view('backend.menu_items.index', compact('menuItems'));
    }

    public function create()
    {
        // 🚨 FIX: Yahan 'status' ki jagah 'is_active' kar diya hai taake error na aaye
        $categories = Category::where('is_active', 1)->get();
        return view('backend.menu_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:menu_items,name',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
        ];

        // Image Upload Logic (public/uploads/menu_items mein)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/menu_items'), $imageName);
            $data['image'] = $imageName;
        }

        MenuItem::create($data);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu Item added successfully!');
    }

    public function edit(MenuItem $menuItem)
    {
        // 🚨 FIX: Yahan bhi 'status' ki jagah 'is_active' kar diya hai
        $categories = Category::where('is_active', 1)->get();
        return view('backend.menu_items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:menu_items,name,' . $menuItem->id,
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Purani image delete karein taake storage bache
            if ($menuItem->image && File::exists(public_path('uploads/menu_items/'.$menuItem->image))) {
                File::delete(public_path('uploads/menu_items/'.$menuItem->image));
            }
            
            // Nayi image upload
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/menu_items'), $imageName);
            $data['image'] = $imageName;
        }

        $menuItem->update($data);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu Item updated successfully!');
    }

    public function destroy(MenuItem $menuItem)
    {
        // Item delete karne se pehle image delete karein
        if ($menuItem->image && File::exists(public_path('uploads/menu_items/'.$menuItem->image))) {
            File::delete(public_path('uploads/menu_items/'.$menuItem->image));
        }
        
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu Item deleted successfully!');
    }
}