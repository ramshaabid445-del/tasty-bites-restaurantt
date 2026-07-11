@extends('frontend.layouts.app')

@section('title', 'Tasty Bites - Fresh Fast Food')

@section('content')
<article>
  <section class="hero" id="home" style="background-image: url('{{ asset('frontend/assets/images/hero-bg.jpg') }}')">
    <div class="container">
      <div class="hero-content" data-aos="fade-up">
        <p class="hero-subtitle">Eat Sleep And</p>
        <h2 class="h1 hero-title">Super delicious Burger in town!</h2>
        <p class="hero-text">Order customer favorites from the live menu and book your table in a few taps.</p>
        <a href="{{ route('frontend.shop.index') }}" class="btn">Order Now</a>
        <a href="{{ route('frontend.reservation.create') }}" class="btn btn-hover">Book A Table</a>
      </div>
      <figure class="hero-banner">
        <img src="{{ asset('frontend/assets/images/hero-banner-bg.png') }}" width="820" height="716" alt="" aria-hidden="true" class="w-100 hero-img-bg">
        <img src="{{ asset('frontend/assets/images/hero-banner.png') }}" width="700" height="637" loading="lazy" alt="Tasty burger meal" class="w-100 hero-img">
      </figure>
    </div>
  </section>

  <section class="section section-divider white promo">
    <div class="container">
      <ul class="promo-list has-scrollbar">
        @forelse($categories as $category)
          <li class="promo-item">
            <a class="promo-card" href="{{ route('frontend.shop.index', ['category' => $category->slug]) }}" data-aos="fade-up">
              <h3 class="h3 card-title">{{ $category->name }}</h3>

              <img src="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('frontend/assets/images/promo-1.png') }}" width="300" height="300" loading="lazy" alt="{{ $category->name }}" class="w-100 card-banner">
            </a>
          </li>
        @empty
          <li class="promo-item"><div class="promo-card"><h3 class="h3 card-title">Menu Coming Soon</h3><p class="card-text">Add categories in admin to show them here.</p></div></li>
        @endforelse
      </ul>
    </div>
  </section>

  <section class="section section-divider gray food-menu" id="food-menu">
    <div class="container">
      <p class="section-subtitle">Popular Dishes</p>
      <h2 class="h2 section-title">Our Delicious <span class="span">Foods</span></h2>
      <p class="section-text">Featured menu items are pulled from your admin menu catalog.</p>
      <ul class="fiter-list">
        <li><a class="filter-btn active" href="{{ route('frontend.shop.index') }}">View Full Menu</a></li>
      </ul>
      <ul class="food-menu-list">
        @foreach(($featuredItems->isNotEmpty() ? $featuredItems : $latestItems) as $item)
          <li>@include('frontend.partials.menu-card', ['item' => $item])</li>
        @endforeach
      </ul>
    </div>
  </section>

  <section class="section section-divider white cta" style="background-image: url('{{ asset('frontend/assets/images/hero-bg.jpg') }}')">
    <div class="container">
      <div class="cta-content" data-aos="fade-right">
        <h2 class="h2 section-title">Fresh, fast, and tracked from <span class="span">order to kitchen</span></h2>
        <p class="section-text">Every online order lands in the same orders table your admin live screen already uses.</p>
        <a href="{{ route('frontend.shop.index') }}" class="btn btn-hover">Order Now</a>
      </div>
      <figure class="cta-banner"><img src="{{ asset('frontend/assets/images/cta-banner.png') }}" width="700" height="637" loading="lazy" alt="Burger combo" class="w-100 cta-img"></figure>
    </div>
  </section>

  <section class="section section-divider white blog" id="blog">
    <div class="container">
      <p class="section-subtitle">Latest Blog Posts</p>
      <h2 class="h2 section-title">This Is All About <span class="span">Foods</span></h2>
      <ul class="blog-list">
        @forelse($posts as $post)
          <li>@include('frontend.blog._card', ['post' => $post])</li>
        @empty
          <li><div class="blog-card"><div class="card-content"><h3 class="h3">No posts published yet.</h3><p class="card-text">Publish blog posts to feature them here.</p></div></div></li>
        @endforelse
      </ul>
    </div>
  </section>
</article>
@endsection
