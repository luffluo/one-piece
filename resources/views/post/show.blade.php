@extends('layouts.main')

@section('title', $post->title)

@section('content')
    <div class="blog-post">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        <p class="blog-post-meta">{{ $post->created_at->format('Y-m-d') }} <a href="#">Luff</a></p>
        <div>{{ $post->text }}</div>
    </div>
@endsection