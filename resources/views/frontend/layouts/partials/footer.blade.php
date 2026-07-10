<footer class="footer">
  <div class="footer-top" style="background-image: url('{{ asset('frontend/assets/images/footer-illustration.png') }}')">
    <div class="container">
      <div class="footer-brand">
        <a href="{{ route('frontend.home') }}" class="logo">Tasty Bites<span class="span">.</span></a>
        <p class="footer-text">Fresh fast food, table bookings, and quick delivery from one kitchen your admin panel can track.</p>
        <ul class="social-list">
          <li><a href="#" class="social-link" aria-label="Facebook"><ion-icon name="logo-facebook"></ion-icon></a></li>
          <li><a href="#" class="social-link" aria-label="Twitter"><ion-icon name="logo-twitter"></ion-icon></a></li>
          <li><a href="#" class="social-link" aria-label="Instagram"><ion-icon name="logo-instagram"></ion-icon></a></li>
        </ul>
      </div>
      <ul class="footer-list">
        <li><p class="footer-list-title">Contact Info</p></li>
        <li><p class="footer-list-item">+92 (062) 109-9222</p></li>
        <li><p class="footer-list-item">Info.tastybites11@gmail.com</p></li>
        <li><address class="footer-list-item">153 Williamson Plaza, Maggieberg, MT 09514</address></li>
      </ul>
      <ul class="footer-list">
        <li><p class="footer-list-title">Opening Hours</p></li>
        <li><p class="footer-list-item">Monday-Friday: 01:00pm-12:00am</p></li>
        <li><p class="footer-list-item">Saturday-Sunday: 12:00pm-01:00am</p></li>
      </ul>
      <form action="{{ route('frontend.reservation.store') }}" method="POST" class="footer-form">
        @csrf
        <p class="footer-list-title">Book a Table</p>
        <div class="input-wrapper">
          <input type="text" name="customer_name" required placeholder="Your Name" class="input-field">
          <input type="email" name="email" placeholder="Email" class="input-field">
        </div>
        <div class="input-wrapper">
          <input type="tel" name="phone" required placeholder="Phone" class="input-field">
          <input type="number" name="party_size" min="1" value="2" class="input-field">
        </div>
        <div class="input-wrapper">
          <input type="date" name="reservation_date" min="{{ now()->toDateString() }}" required class="input-field">
          <input type="time" name="reservation_time" required class="input-field">
        </div>
        <textarea name="notes" placeholder="Special request" class="input-field"></textarea>
        <button type="submit" class="btn">Book a Table</button>
      </form>
    </div>
  </div>
  <div class="footer-bottom"><div class="container"><p class="copyright-text">&copy; 2026 <a href="{{ route('frontend.home') }}" class="copyright-link">Tasty Bites</a> All Rights Reserved.</p></div></div>
</footer>
