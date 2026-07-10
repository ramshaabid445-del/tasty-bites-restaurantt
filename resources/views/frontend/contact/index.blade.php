@extends('frontend.layouts.app')

@section('title', 'Contact Us - Tasty Bites')

@section('content')
<section class="section section-divider white page-section">
  <div class="container contact-grid">
    <div>
      <p class="section-subtitle">Contact Us</p>
      <h1 class="h2 section-title">Talk To <span class="span">Tasty Bites</span></h1>
      <p class="section-text">Phone: +92 (062) 109-9222</p>
      <p class="section-text">Email: Info.tastybites11@gmail.com</p>
      <p class="section-text">Address: 153 Williamson Plaza, Maggieberg, MT 09514</p>
      <iframe title="Tasty Bites map" src="https://maps.google.com/maps?q=restaurant&t=&z=13&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>
    </div>
    <form method="POST" action="{{ route('frontend.contact.store') }}" class="frontend-form">
      @csrf
      <input class="input-field" name="name" value="{{ old('name') }}" placeholder="Name" required>
      <input class="input-field" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
      <input class="input-field" name="subject" value="{{ old('subject') }}" placeholder="Subject" required>
      <textarea class="input-field" name="message" placeholder="Message" required>{{ old('message') }}</textarea>
      @if($errors->any())<div class="form-errors">{{ $errors->first() }}</div>@endif
      <button class="btn" type="submit">Send Message</button>
    </form>
  </div>
</section>
@endsection
