<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order; 
use App\Models\Expense; 
use App\Models\TaxSetting; 
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function salesIndex() {
        $sales = Order::where('status', 'completed')->latest()->get();
        $total_sales = $sales->sum('total_amount');
        return view('backend.management.finance.sales', compact('sales', 'total_sales'));
    }

    public function expenseIndex() {
        $expenses = Expense::latest()->get();
        return view('backend.management.finance.expenses', compact('expenses'));
    }

    public function storeExpense(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create($request->all());
        return redirect()->back()->with('success', 'Expense Added Successfully!');
    }

    public function taxIndex() {
        $tax = TaxSetting::first() ?? new TaxSetting(); 
        return view('backend.management.finance.taxes', compact('tax'));
    }

    public function taxUpdate(Request $request) {
        $request->validate([
            'tax_name' => 'required|string|max:50',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        TaxSetting::updateOrCreate(
            ['id' => 1], 
            [
                'tax_name' => strtoupper($request->tax_name), 
                'tax_rate' => $request->tax_rate,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]
        );

        return redirect()->back()->with('success', 'Tax configuration updated successfully!');
    }
}