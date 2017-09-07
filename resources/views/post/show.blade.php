@extends('layouts.default')

@section('title', $post->title)

@section('content')
    <article class="post">
        <h2 class="post-title">{{ $post->getTitle() }}</h2>
        <p class="post-meta">
            <span>{{ $post->created_at->format(option('postDateFormat', 'Y-m-d')) }}</span>
        </p>
        <div class="post-content">{!! $post->content() !!}</div>
    </article>
@endsection