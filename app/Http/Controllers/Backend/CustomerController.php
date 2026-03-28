<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feedback; // Yeh zaroori hai
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Customer Database Page
    public function index()
    {
        $customers = Customer::latest()->get();
        // Check karein ke aapki file ka naam 'index' hai ya 'customers'
        return view('backend.management.crm.customers', compact('customers'));
    }

    // 2. Loyalty Points Page
    public function loyalty()
    {
        // Top 10 customers points ke hisab se
        $top_customers = Customer::orderBy('loyalty_points', 'desc')->take(10)->get();
        return view('backend.management.crm.loyalty', compact('top_customers'));
    }

    // 3. Feedback & Reviews Page
    public function feedback()
    {
        // Feedback ke saath customer ka naam bhi uthayega (Eager Loading)
        $feedbacks = Feedback::with('customer')->latest()->get();
        return view('backend.management.crm.feedback', compact('feedbacks'));
    }

    // 4. Save New Customer
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers,phone',
            'email' => 'nullable|email|unique:customers,email',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'loyalty_points' => 0, // Shuru mein zero points
        ]);

        return redirect()->back()->with('success', 'Customer added successfully!');
    }
}