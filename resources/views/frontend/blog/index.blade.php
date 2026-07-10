@extends('frontend.layouts.app')

@section('title', 'Blog - Tasty Bites')

@section('content')
<section class="section section-divider white blog page-section blog-page">
  <div class="container">
    <div class="blog-page-head" data-aos="fade-up">
      <p class="section-subtitle">Blog</p>
      <h1 class="h2 section-title">Fresh From The <span class="span">Kitchen</span></h1>
      <p class="section-text">Read menu updates, kitchen stories, offers, and food guides published from your restaurant database.</p>
    </div>
    <ul class="blog-list">
      @forelse($posts as $post)
        <li>@include('frontend.blog._card', ['post' => $post])</li>
      @empty
        <li class="empty-state empty-state-rich">
          <ion-icon name="newspaper-outline"></ion-icon>
          <h2>No published blog posts yet</h2>
          <p>Once posts are published in the database, this section will turn into a polished food magazine grid.</p>
        </li>
      @endforelse
    </ul>
    <div class="pagination-wrap">{{ $posts->links() }}</div>
  </div>
</section>
@endsection
