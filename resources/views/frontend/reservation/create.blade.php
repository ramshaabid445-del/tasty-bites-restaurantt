@extends('frontend.layouts.app')

@section('title', 'Reservation - Tasty Bites')

@section('content')
<section class="section section-divider white page-section">
  <div class="container narrow-page">
    <p class="section-subtitle">Book a Table</p>
    <h1 class="h2 section-title">Reserve Your <span class="span">Seat</span></h1>
    <form method="POST" action="{{ route('frontend.reservation.store') }}" class="frontend-form">
      @csrf
      <input class="input-field" name="customer_name" value="{{ old('customer_name') }}" placeholder="Full name" required>
      <input class="input-field" name="phone" value="{{ old('phone') }}" placeholder="Phone" required>
      <input class="input-field" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
      <div class="input-wrapper"><input class="input-field" type="date" name="reservation_date" min="{{ now()->toDateString() }}" value="{{ old('reservation_date') }}" required><input class="input-field" type="time" name="reservation_time" value="{{ old('reservation_time') }}" required></div>
      <input class="input-field" type="number" name="party_size" min="1" max="30" value="{{ old('party_size', 2) }}" required>
      <select class="input-field" name="dining_table_id"><option value="">Admin can assign table</option>@foreach($tables as $table)<option value="{{ $table->id }}">{{ $table->name }} ({{ $table->capacity }} seats)</option>@endforeach</select>
      <textarea class="input-field" name="notes" placeholder="Special request">{{ old('notes') }}</textarea>
      @if($errors->any())<div class="form-errors">{{ $errors->first() }}</div>@endif
      <button class="btn" type="submit">Submit Reservation</button>
    </form>
  </div>
</section>
@endsection
