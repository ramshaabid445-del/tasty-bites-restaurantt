@php($image = $item->image ? asset('uploads/menu_items/' . $item->image) : asset('frontend/assets/images/food-menu-1.png'))
<div class="food-menu-card" data-aos="fade-up">
  <div class="card-banner">
    <img src="{{ $image }}" width="300" height="300" loading="lazy" alt="{{ $item->name }}" class="w-100">
    @if($item->discount_price)<div class="badge">Sale</div>@endif
    <button class="btn food-menu-btn" data-add-to-cart data-menu-item-id="{{ $item->id }}">Order Now</button>
  </div>
  <div class="wrapper">
    <p class="category">{{ $item->category?->name ?? 'Menu' }}</p>
    <div class="rating-wrapper"><ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon></div>
  </div>
  <h3 class="h3 card-title"><a href="{{ route('frontend.menu.show', $item) }}">{{ $item->name }}</a></h3>
  <div class="price-wrapper">
    <p class="price-text">Price:</p>
    <data class="price" value="{{ $item->current_price }}">Rs. {{ number_format($item->current_price, 2) }}</data>
    @if($item->discount_price)<del class="del">Rs. {{ number_format($item->price, 2) }}</del>@endif
  </div>
  <a href="{{ route('frontend.menu.show', $item) }}" class="btn-link"><span>Read More</span><ion-icon name="arrow-forward"></ion-icon></a>
</div>
