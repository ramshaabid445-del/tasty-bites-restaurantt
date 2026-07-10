<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend.blog.index', [
            'posts' => BlogPost::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_if(is_null($post->published_at) || $post->published_at->isFuture(), 404);

        return view('frontend.blog.show', [
            'post' => $post,
            'relatedPosts' => BlogPost::published()
                ->whereKeyNot($post->id)
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
