<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\MenuItem;

class MenuItemController extends Controller
{
    public function show(MenuItem $menuItem)
    {
        abort_unless($menuItem->is_available, 404);

        return view('frontend.menu.show', [
            'item' => $menuItem->load('category'),
            'addons' => Addon::active()->orderBy('name')->get(),
            'relatedItems' => MenuItem::with('category')
                ->active()
                ->where('category_id', $menuItem->category_id)
                ->whereKeyNot($menuItem->id)
                ->take(4)
                ->get(),
        ]);
    }
}
