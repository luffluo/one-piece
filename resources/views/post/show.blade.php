@extends('layouts.main')

@section('title', $post->title)

@section('content')
    <div class="blog-post">
        <h2 class="blog-post-title">{{ $post->title }}</h2>
        <p class="blog-post-meta">
            <span>{{ $post->created_at->format('Y-m-d') }} <a href="#">Luff</a></span>
        </p>
        <div>{!! app('HyperDown')->makeHtml($post->text) !!}</div>
    </div>
@endsection