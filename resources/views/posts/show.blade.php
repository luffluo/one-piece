@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div id="article" class="row">
    <div id="main" class="eleven wide column" role="main">
        <article class="post">

            <h2 class="ui sub header" itemprop="name headline">{{ $post->headline() }}</h2>

            <div class="ui small horizontal divided list">
                <div class="item">
                    <time>{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                </div>

                <div class="item">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                    @endforeach
                </div>
            </div>

            <div class="post-content">{!! $post->content() !!}</div>

        </article>

        <div class="ui divider"></div>

        @include('comments._list', ['collections' => $comments->first(null, [])])
    </div>

    @include('common._sidebar')
</div>
@endsection
