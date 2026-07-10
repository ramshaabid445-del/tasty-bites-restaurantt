<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Customer Database Page
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('backend.management.crm.customers', compact('customers'));
    }

    // 2. Loyalty Page Method (Jo missing tha)
    public function loyalty()
    {
        // Sab customers aur total points calculate karke view ko bhej raha hai
        $customers = Customer::orderBy('loyalty_points', 'desc')->get();
        $totalPoints = Customer::sum('loyalty_points');
        
        return view('backend.management.crm.loyalty', compact('customers', 'totalPoints'));
    }

    // 3. Add Manual Points Logic
    public function addLoyaltyPoints(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'points' => 'required|numeric|min:1',
        ]);

        $customer = Customer::findOrFail($request->customer_id);
        
        // Column name 'loyalty_points' use kiya hai jo aapke store method mein hai
        $customer->loyalty_points += $request->points;
        $customer->save();

        return redirect()->back()->with('success', 'Points added successfully!');
    }

    // 4. Feedback & Reviews Page
    public function feedback()
    {
        $feedbacks = Feedback::with('customer')->latest()->get();
        return view('backend.management.crm.feedback', compact('feedbacks'));
    }

    // 5. Save New Customer
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
            'loyalty_points' => 0, 
        ]);

        return redirect()->back()->with('success', 'Customer added successfully!');
    }
}