<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Models\Customer;
use App\Models\DiningTable;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (empty(session('cart', []))) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty.');
        }

        return view('frontend.checkout.index', [
            'cart' => session('cart', []),
            'cartTotal' => $this->total(),
            'tables' => DiningTable::available()->orderBy('name')->get(),
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty.');
        }

        $userId = auth()->id() ?: User::query()->value('id');
        abort_unless($userId, 422, 'Please create an admin user before accepting customer orders.');

        $order = DB::transaction(function () use ($request, $cart, $userId) {
            $lookup = $request->customer_email
                ? ['email' => $request->customer_email]
                : ['phone' => $request->customer_phone];

            $customer = Customer::updateOrCreate($lookup, [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
                'address' => $request->customer_address,
            ]);

            $subTotal = $this->total();
            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis') . random_int(10, 99),
                'user_id' => $userId,
                'dining_table_id' => $request->order_type === 'dine_in' ? $request->dining_table_id : null,
                'customer_name' => $customer->name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'order_type' => $request->order_type === 'pickup' ? 'takeaway' : $request->order_type,
                'status' => 'pending',
                'sub_total' => $subTotal,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $subTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
                'estimated_ready_at' => now()->addMinutes(35),
                'notes' => $request->notes,
            ]);

            foreach ($cart as $row) {
                $addonsTotal = collect($row['addons'] ?? [])->sum('price');
                $unitPrice = (float) $row['unit_price'] + (float) $addonsTotal;

                $order->items()->create([
                    'menu_item_id' => $row['menu_item_id'],
                    'quantity' => $row['quantity'],
                    'unit_price' => $unitPrice,
                    'addons' => $row['addons'] ?? [],
                    'sub_total' => $unitPrice * (int) $row['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('frontend.orders.confirmation', $order)->with('success', 'Order placed successfully.');
    }

    public function confirmation(Order $order)
    {
        return view('frontend.checkout.confirmation', [
            'order' => $order->load('items.menuItem', 'diningTable'),
        ]);
    }

    private function total(): float
    {
        return collect(session('cart', []))->sum(function ($row) {
            $addons = collect($row['addons'] ?? [])->sum('price');
            return ((float) $row['unit_price'] + (float) $addons) * (int) $row['quantity'];
        });
    }
}
