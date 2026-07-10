@php($image = $post->featured_image ? asset('uploads/blog_posts/' . $post->featured_image) : asset('frontend/assets/images/blog-1.jpg'))
<div class="blog-card" data-aos="fade-up">
  <div class="card-banner"><img src="{{ $image }}" width="600" height="390" loading="lazy" alt="{{ $post->title }}" class="w-100"><div class="badge">Food Story</div></div>
  <div class="card-content">
    <div class="card-meta-wrapper">
      <span class="card-meta-link"><ion-icon name="calendar-outline"></ion-icon><time class="meta-info" datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->format('M d, Y') }}</time></span>
      <span class="card-meta-link"><ion-icon name="person-outline"></ion-icon><span class="meta-info">{{ $post->author ?: 'Tasty Bites' }}</span></span>
    </div>
    <h3 class="h3"><a href="{{ route('frontend.blog.show', $post) }}" class="card-title">{{ $post->title }}</a></h3>
    <p class="card-text">{{ $post->excerpt ?: str($post->content)->stripTags()->limit(140) }}</p>
    <a href="{{ route('frontend.blog.show', $post) }}" class="btn-link"><span>Read More</span><ion-icon name="arrow-forward"></ion-icon></a>
  </div>
</div>
