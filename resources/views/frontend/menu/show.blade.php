@extends('frontend.layouts.app')

@section('title', $item->name . ' - Tasty Bites')
@section('meta_description', $item->short_description)

@section('content')
@php($image = $item->image ? asset('uploads/menu_items/' . $item->image) : asset('frontend/assets/images/food-menu-1.png'))
<section class="section section-divider white page-section">
  <div class="container">
    <nav class="breadcrumb"><a href="{{ route('frontend.home') }}">Home</a> / <a href="{{ route('frontend.shop.index') }}">Shop</a> / <span>{{ $item->name }}</span></nav>
    <div class="item-detail">
      <figure data-aos="fade-right"><img src="{{ $image }}" alt="{{ $item->name }}" class="item-detail-img"></figure>
      <div data-aos="fade-left">
        <p class="section-subtitle">{{ $item->category?->name }}</p>
        <h1 class="h2 section-title">{{ $item->name }}</h1>
        <p class="section-text">{{ $item->description }}</p>
        <p class="detail-price">Rs. <span data-base-price="{{ $item->current_price }}" data-total-price>{{ number_format($item->current_price, 2) }}</span></p>
        <form data-add-to-cart-form>
          <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
          <div class="addon-list">
            @foreach($addons as $addon)
              <label><input type="checkbox" name="addons[]" value="{{ $addon->id }}" data-addon-price="{{ $addon->price }}"> {{ $addon->name }} (+Rs. {{ number_format($addon->price, 2) }})</label>
            @endforeach
          </div>
          <div class="qty-control"><button type="button" data-qty-minus>-</button><input type="number" name="quantity" value="1" min="1" max="50" data-qty-input><button type="button" data-qty-plus>+</button></div>
          <button class="btn" type="submit">Add to Cart</button>
        </form>
      </div>
    </div>
  </div>
</section>
<section class="section section-divider gray food-menu">
  <div class="container">
    <h2 class="h2 section-title">Related <span class="span">Items</span></h2>
    <ul class="food-menu-list">
      @foreach($relatedItems as $related)<li>@include('frontend.partials.menu-card', ['item' => $related])</li>@endforeach
    </ul>
  </div>
</section>
@endsection
