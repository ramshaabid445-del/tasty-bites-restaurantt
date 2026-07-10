<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $items = MenuItem::query()
            ->with('category')
            ->active()
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->category)))
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->min_price))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->max_price));

        match ($request->get('sort')) {
            'price_low' => $items->orderBy('price'),
            'price_high' => $items->orderByDesc('price'),
            'popular' => $items->withSum('orderItems as sold_qty', 'quantity')->orderByDesc('sold_qty'),
            default => $items->latest(),
        };

        return view('frontend.shop.index', [
            'items' => $items->paginate(12)->withQueryString(),
            'categories' => Category::active()->orderBy('name')->get(),
        ]);
    }
}
