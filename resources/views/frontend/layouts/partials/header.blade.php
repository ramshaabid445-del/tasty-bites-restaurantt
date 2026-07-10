@php($cartCount = collect(session('cart', []))->sum('quantity'))
@php($isHome = request()->routeIs('frontend.home'))
<header class="header {{ $isHome ? 'header-home' : 'header-page' }}" data-header>
  <div class="container">
    <h1><a href="{{ route('frontend.home') }}" class="logo">Tasty Bites<span class="span">.</span></a></h1>
    <nav class="navbar" data-navbar>
      <ul class="navbar-list">
        <li class="nav-item"><a href="{{ route('frontend.home') }}" class="navbar-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}" data-nav-link>Home</a></li>
        <li class="nav-item"><a href="{{ route('frontend.about') }}" class="navbar-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}" data-nav-link>About Us</a></li>
        <li class="nav-item"><a href="{{ route('frontend.shop.index') }}" class="navbar-link {{ request()->routeIs('frontend.shop.*', 'frontend.menu.*') ? 'active' : '' }}" data-nav-link>Shop</a></li>
        <li class="nav-item"><a href="{{ route('frontend.blog.index') }}" class="navbar-link {{ request()->routeIs('frontend.blog.*') ? 'active' : '' }}" data-nav-link>Blog</a></li>
        <li class="nav-item"><a href="{{ route('frontend.contact.index') }}" class="navbar-link {{ request()->routeIs('frontend.contact.*') ? 'active' : '' }}" data-nav-link>Contact Us</a></li>
      </ul>
    </nav>
    <div class="header-btn-group">
      <button class="search-btn" aria-label="Search" data-search-btn><ion-icon name="search-outline"></ion-icon></button>
      <a href="{{ route('frontend.cart.index') }}" class="cart-link" aria-label="Cart"><ion-icon name="cart-outline"></ion-icon><span data-cart-count>{{ $cartCount }}</span></a>
      <a href="{{ route('frontend.reservation.create') }}" class="btn btn-hover">Reservation</a>
      <button class="nav-toggle-btn" aria-label="Toggle Menu" data-menu-toggle-btn><span class="line top"></span><span class="line middle"></span><span class="line bottom"></span></button>
    </div>
  </div>
</header>
