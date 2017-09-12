@extends('layouts.default')

@section('title', $post->title)

@section('content')
    @if (isset($sidebarBlock) && count($sidebarBlock) > 0)
        <div id="main" class="col-md-8 main" role="main">
    @else
        <div id="main" class="col-md-8 col-md-offset-2" role="main">
    @endif
        <article class="post">
            <h2 class="post-title">{{ $post->getTitle() }}</h2>
            <p class="post-meta">
                <span>{{ $post->created_at->format(option('postDateFormat', 'Y-m-d')) }}</span>
            </p>
            <div class="post-content">{!! $post->content() !!}</div>
        </article>
    </div>

    @include('common.sidebar')
@endsection
