@extends('frontend.layouts.app')

@section('title', 'Checkout - Tasty Bites')

@section('content')
<section class="section section-divider gray page-section">
  <div class="container checkout-grid">
    <form method="POST" action="{{ route('frontend.checkout.store') }}" class="checkout-form">
      @csrf
      <h1 class="h2 section-title">Checkout</h1>
      <input class="input-field" name="customer_name" value="{{ old('customer_name') }}" placeholder="Full name" required>
      <input class="input-field" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="Phone" required>
      <input class="input-field" type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="Email">
      <div class="segmented">
        <label><input type="radio" name="order_type" value="delivery" checked> Delivery</label>
        <label><input type="radio" name="order_type" value="pickup"> Pickup</label>
        <label><input type="radio" name="order_type" value="dine_in"> Dine-in</label>
      </div>
      <textarea class="input-field" name="customer_address" placeholder="Delivery address">{{ old('customer_address') }}</textarea>
      <select class="input-field" name="dining_table_id">
        <option value="">Select table for dine-in</option>
        @foreach($tables as $table)<option value="{{ $table->id }}">{{ $table->name }} ({{ $table->capacity }} seats)</option>@endforeach
      </select>
      <select class="input-field" name="payment_method"><option value="cash">Cash on Delivery</option><option value="card">Card (pay at counter)</option></select>
      <textarea class="input-field" name="notes" placeholder="Order notes">{{ old('notes') }}</textarea>
      <button class="btn" type="submit">Place Order</button>
    </form>
    <aside class="order-summary">
      <h2>Order Summary</h2>
      @foreach($cart as $row)<p>{{ $row['quantity'] }} x {{ $row['name'] }} <span>Rs. {{ number_format(((float)$row['unit_price'] + collect($row['addons'] ?? [])->sum('price')) * (int)$row['quantity'], 2) }}</span></p>@endforeach
      <strong>Total: Rs. {{ number_format($cartTotal, 2) }}</strong>
    </aside>
  </div>
</section>
@endsection
