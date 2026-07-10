@extends('frontend.layouts.app')

@section('title', $post->title . ' - Tasty Bites')
@section('meta_description', $post->excerpt ?: str($post->content)->stripTags()->limit(150))

@section('content')
<article class="section section-divider white page-section blog-detail-page">
  <div class="container narrow-page">
    <div class="blog-detail-head" data-aos="fade-up">
      <p class="section-subtitle">{{ optional($post->published_at)->format('M d, Y') }} / {{ $post->author ?: 'Tasty Bites' }}</p>
      <h1 class="h2 section-title">{{ $post->title }}</h1>
    </div>
    <img class="blog-hero" data-aos="fade-up" src="{{ $post->featured_image ? asset('uploads/blog_posts/' . $post->featured_image) : asset('frontend/assets/images/blog-1.jpg') }}" alt="{{ $post->title }}">
    <div class="blog-content" data-aos="fade-up">{!! nl2br(e($post->content)) !!}</div>
  </div>
</article>
<section class="section section-divider gray blog">
  <div class="container">
    <h2 class="h2 section-title">Related <span class="span">Posts</span></h2>
    <ul class="blog-list">@foreach($relatedPosts as $related)<li>@include('frontend.blog._card', ['post' => $related])</li>@endforeach</ul>
  </div>
</section>
@endsection
