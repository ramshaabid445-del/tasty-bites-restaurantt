@extends('frontend.layouts.app')

@section('title', 'Shop Menu - Tasty Bites')

@section('content')
<section class="section section-divider gray food-menu page-section">
  <div class="container">
    <p class="section-subtitle">Shop</p>
    <h1 class="h2 section-title">Order From Our <span class="span">Live Menu</span></h1>
    <form class="shop-filter" method="GET">
      <input class="input-field" type="search" name="search" value="{{ request('search') }}" placeholder="Search menu">
      <select class="input-field" name="category">
        <option value="">All categories</option>
        @foreach($categories as $category)<option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>@endforeach
      </select>
      <input class="input-field" type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min price">
      <input class="input-field" type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max price">
      <select class="input-field" name="sort">
        <option value="">Newest</option>
        <option value="price_low" @selected(request('sort') === 'price_low')>Price low-high</option>
        <option value="price_high" @selected(request('sort') === 'price_high')>Price high-low</option>
        <option value="popular" @selected(request('sort') === 'popular')>Popularity</option>
      </select>
      <button class="btn" type="submit">Filter</button>
    </form>
    <ul class="food-menu-list">
      @forelse($items as $item)
        <li>@include('frontend.partials.menu-card', ['item' => $item])</li>
      @empty
        <li class="empty-state">No menu items match your filters.</li>
      @endforelse
    </ul>
    <div class="pagination-wrap">{{ $items->links() }}</div>
  </div>
</section>
@endsection
