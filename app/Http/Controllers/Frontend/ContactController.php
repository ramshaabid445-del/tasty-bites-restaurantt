<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(ContactRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Your message has been sent.');
    }
}
