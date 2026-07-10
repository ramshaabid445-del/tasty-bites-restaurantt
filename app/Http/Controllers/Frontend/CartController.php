<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart.index', [
            'cart' => $this->cart(),
            'cartTotal' => $this->total(),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'menu_item_id' => ['required', 'exists:menu_items,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:50'],
            'addons' => ['nullable', 'array'],
            'addons.*' => ['integer', 'exists:addons,id'],
        ]);

        $item = MenuItem::active()->findOrFail($data['menu_item_id']);
        $addons = Addon::active()->whereIn('id', $data['addons'] ?? [])->get();
        $addonPayload = $addons->map(fn (Addon $addon) => [
            'id' => $addon->id,
            'name' => $addon->name,
            'price' => (float) $addon->price,
        ])->values()->all();

        $rowId = md5($item->id . ':' . collect($addonPayload)->pluck('id')->sort()->implode(','));
        $cart = $this->cart();
        $quantity = (int) ($data['quantity'] ?? 1);

        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] += $quantity;
        } else {
            $cart[$rowId] = [
                'row_id' => $rowId,
                'menu_item_id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'image' => $item->image,
                'unit_price' => (float) $item->current_price,
                'addons' => $addonPayload,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'message' => 'Added to cart',
            'count' => $this->count(),
            'total' => number_format($this->total(), 2),
        ]);
    }

    public function update(Request $request, string $rowId)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:50']]);
        $cart = $this->cart();

        abort_unless(isset($cart[$rowId]), 404);

        $cart[$rowId]['quantity'] = (int) $data['quantity'];
        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(string $rowId)
    {
        $cart = $this->cart();
        unset($cart[$rowId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed.');
    }

    public function summary()
    {
        return response()->json([
            'count' => $this->count(),
            'total' => number_format($this->total(), 2),
        ]);
    }

    private function cart(): array
    {
        return session('cart', []);
    }

    private function count(): int
    {
        return collect($this->cart())->sum('quantity');
    }

    private function total(): float
    {
        return collect($this->cart())->sum(function ($row) {
            $addons = collect($row['addons'] ?? [])->sum('price');
            return ((float) $row['unit_price'] + (float) $addons) * (int) $row['quantity'];
        });
    }
}
