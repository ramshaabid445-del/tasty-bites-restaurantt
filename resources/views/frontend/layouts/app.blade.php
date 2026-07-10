<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('meta_description', 'Order fresh burgers, pizzas, drinks, and dine-in favorites from Tasty Bites.')">
  <title>@yield('title', 'Tasty Bites')</title>
  <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.svg') }}" type="image/svg+xml">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/frontend-custom.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&family=Rubik:wght@400;500;600;700&family=Shadows+Into+Light&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @stack('styles')
</head>
<body id="top">
  @include('frontend.layouts.partials.header')

  <div class="search-container" data-search-container>
    <div class="search-box">
      <input type="search" aria-label="Search menu" placeholder="Search burgers, pizza, drinks..." class="search-input" data-live-search-url="{{ route('frontend.search.menu-items') }}">
      <button class="search-submit" aria-label="Submit search"><ion-icon name="search-outline"></ion-icon></button>
    </div>
    <div class="live-search-results" data-search-results></div>
    <button class="search-close-btn" aria-label="Cancel search" data-search-close-btn></button>
  </div>

  <main>
    @if (session('success'))
      <div class="flash-toast is-success" data-flash-message>{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="flash-toast is-error" data-flash-message>{{ session('error') }}</div>
    @endif
    @yield('content')
  </main>

  @include('frontend.layouts.partials.footer')

  <a href="#top" class="back-top-btn" aria-label="Back to top" data-back-top-btn>
    <ion-icon name="chevron-up"></ion-icon>
  </a>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="{{ asset('frontend/assets/js/script.js') }}" defer></script>
  <script src="{{ asset('frontend/assets/js/frontend.js') }}" defer></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  @stack('scripts')
</body>
</html>
