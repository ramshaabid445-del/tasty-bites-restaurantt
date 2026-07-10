@extends('frontend.layouts.app')

@section('title', 'Order Confirmed - Tasty Bites')

@section('content')
<section class="section section-divider white page-section">
  <div class="container confirmation-box">
    <p class="section-subtitle">Thank you</p>
    <h1 class="h2 section-title">Order <span class="span">{{ $order->order_number }}</span> Confirmed</h1>
    <p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
    <p>Estimated ready time: {{ optional($order->estimated_ready_at)->format('h:i A') ?? 'Soon' }}</p>
    @foreach($order->items as $item)<p>{{ $item->quantity }} x {{ $item->menuItem?->name }} - Rs. {{ number_format($item->sub_total, 2) }}</p>@endforeach
    <h2>Total: Rs. {{ number_format($order->total_amount, 2) }}</h2>
    <a href="{{ route('frontend.shop.index') }}" class="btn">Order More</a>
  </div>
</section>
@endsection
