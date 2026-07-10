<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;

class AboutController extends Controller
{
    public function __invoke()
    {
        return view('frontend.about.index', [
            'stats' => [
                'dishes' => MenuItem::active()->count(),
                'categories' => Category::active()->count(),
                'orders' => Order::count(),
                'years' => 5,
            ],
        ]);
    }
}
