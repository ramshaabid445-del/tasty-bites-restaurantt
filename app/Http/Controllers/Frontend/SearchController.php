<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $term = trim((string) $request->get('q'));

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        return MenuItem::active()
            ->where('name', 'like', '%' . $term . '%')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn (MenuItem $item) => [
                'name' => $item->name,
                'price' => number_format((float) $item->current_price, 2),
                'image' => $item->image ? asset('uploads/menu_items/' . $item->image) : asset('frontend/assets/images/food-menu-1.png'),
                'url' => route('frontend.menu.show', $item),
            ]);
    }
}
