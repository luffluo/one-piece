@extends('layouts.default')

@section('title', $post->title)

@section('content')
    @if (count(sidebar_block()) > 0)
        <div id="main" class="col-md-8 main" role="main">
    @else
        <div id="main" class="col-md-8 col-md-offset-2" role="main">
    @endif
        <article class="post">

            <h2 class="post-title" itemprop="name headline">{{ $post->headline() }}</h2>

            <ul class="post-meta">
                <li>
                    <time>{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                </li>

                <li>
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>
                    @endforeach
                </li>
            </ul>

            <div class="post-content">{!! $post->content() !!}</div>

        </article>

        @include('comment._list', ['collections' => $comments[0]])

    </div>

    @include('common.sidebar')
@endsection
