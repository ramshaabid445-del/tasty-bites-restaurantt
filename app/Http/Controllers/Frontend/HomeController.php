<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\MenuItem;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('frontend.home', [
            'categories' => Category::active()->latest()->take(6)->get(),
            'featuredItems' => MenuItem::with('category')->active()->featured()->latest()->take(8)->get(),
            'latestItems' => MenuItem::with('category')->active()->latest()->take(6)->get(),
            'posts' => BlogPost::published()->latest('published_at')->take(3)->get(),
        ]);
    }
}
