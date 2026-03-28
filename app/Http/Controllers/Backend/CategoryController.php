<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Image delete karne ke liye zaroori hai

class CategoryController extends Controller
{
    // 1. Sab categories ko list karne ke liye
    public function index()
    {
        $categories = Category::latest()->get(); 
        return view('backend.categories.index', compact('categories'));
    }

    // 2. Nayi category banane ka form dikhane ke liye
    public function create()
    {
        return view('backend.categories.create');
    }

    // 3. Form ka data database mein save karne ke liye
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name), // "Fast Food" ko "fast-food" bana dega
            'description' => $request->description,
            'status' => $request->status,
        ];

        // Image Upload Logic (public/uploads/categories mein)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category successfully created!');
    }

    // 4. Category ko edit karne ka form dikhane ke liye
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    // 5. Edited data ko database mein update karne ke liye
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Purani image delete karein taake server full na ho
            if ($category->image && File::exists(public_path('uploads/categories/'.$category->image))) {
                File::delete(public_path('uploads/categories/'.$category->image));
            }
            
            // Nayi image save karein
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category successfully updated!');
    }

    // 6. Category ko delete karne ke liye
    public function destroy(Category $category)
    {
        // Delete image first
        if ($category->image && File::exists(public_path('uploads/categories/'.$category->image))) {
            File::delete(public_path('uploads/categories/'.$category->image));
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}