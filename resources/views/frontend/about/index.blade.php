@extends('frontend.layouts.app')

@section('title', 'About Us - Tasty Bites')

@section('content')
<section class="section section-divider white page-section">
  <div class="container about-grid">
    <div data-aos="fade-right">
      <p class="section-subtitle">About Us</p>
      <h1 class="h2 section-title">Fast Food With A <span class="span">Fresh Heart</span></h1>
      <p class="section-text">Tasty Bites serves burgers, pizza, fries, drinks, and dine-in meals with a kitchen workflow connected directly to restaurant operations.</p>
      <p class="section-text">The public site now uses the same menu, order, table, and customer data your admin panel manages.</p>
    </div>
    <img src="{{ asset('frontend/assets/images/about-banner.png') }}" alt="Tasty Bites kitchen favorites" data-aos="fade-left">
  </div>
</section>
<section class="section section-divider gray">
  <div class="container stats-grid">
    <div><strong>{{ $stats['years'] }}+</strong><span>Years</span></div>
    <div><strong>{{ $stats['dishes'] }}+</strong><span>Dishes</span></div>
    <div><strong>{{ $stats['categories'] }}+</strong><span>Categories</span></div>
    <div><strong>{{ $stats['orders'] }}+</strong><span>Orders</span></div>
  </div>
</section>
@endsection
