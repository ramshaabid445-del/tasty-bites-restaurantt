@extends('frontend.layouts.app')

@section('title', 'Cart - Tasty Bites')

@section('content')
<section class="section section-divider white page-section cart-page">
  <div class="container">
    <div class="page-kicker" data-aos="fade-up">Order Summary</div>
    <h1 class="h2 section-title" data-aos="fade-up">Your <span class="span">Cart</span></h1>
    @if(empty($cart))
      <div class="empty-state empty-state-rich" data-aos="fade-up">
        <ion-icon name="cart-outline"></ion-icon>
        <h2>Your cart is empty</h2>
        <p>Add something fresh from the menu and it will show up here.</p>
        <a class="btn" href="{{ route('frontend.shop.index') }}">Start Ordering</a>
      </div>
    @else
      <div class="cart-table">
        @foreach($cart as $row)
          @php($line = ((float)$row['unit_price'] + collect($row['addons'] ?? [])->sum('price')) * (int)$row['quantity'])
          <div class="cart-row" data-aos="fade-up">
            <img src="{{ $row['image'] ? asset('uploads/menu_items/' . $row['image']) : asset('frontend/assets/images/food-menu-1.png') }}" alt="{{ $row['name'] }}">
            <div class="cart-item-info">
              <h3>{{ $row['name'] }}</h3>
              @foreach($row['addons'] ?? [] as $addon)<small>{{ $addon['name'] }}</small>@endforeach
            </div>
            <form class="cart-qty-form" method="POST" action="{{ route('frontend.cart.update', $row['row_id']) }}">@csrf @method('PATCH')<input class="qty-input" type="number" name="quantity" min="1" value="{{ $row['quantity'] }}"><button class="btn btn-small">Update</button></form>
            <strong class="cart-line-price">Rs. {{ number_format($line, 2) }}</strong>
            <form method="POST" action="{{ route('frontend.cart.destroy', $row['row_id']) }}">@csrf @method('DELETE')<button class="remove-btn" type="submit"><ion-icon name="trash-outline"></ion-icon><span>Remove</span></button></form>
          </div>
        @endforeach
      </div>
      <div class="cart-summary" data-aos="fade-up">
        <div>
          <span>Grand Total</span>
          <h2>Rs. {{ number_format($cartTotal, 2) }}</h2>
        </div>
        <a class="btn btn-hover" href="{{ route('frontend.checkout.index') }}">Proceed to Checkout</a>
      </div>
    @endif
  </div>
</section>
@endsection
