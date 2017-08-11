@extends('layouts.main')

@section('title', $post->title)

@section('content')
    <div class="blog-post">
        <h2 class="blog-post-title">{{ $post->getTitle() }}</h2>
        <p class="blog-post-meta">
            <span>{{ $post->created_at->format('Y-m-d') }}</span>
        </p>
        <div class="post-content">{!! $post->content() !!}</div>
    </div>
@endsection