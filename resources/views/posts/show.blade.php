@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div id="article" class="row">
    <div id="main" class="eleven wide column" role="main">
        <article class="post">

            <h2 class="ui sub header" itemprop="name headline">{{ $post->heading() }}</h2>

            <div class="ui small horizontal divided list">
                <div class="item">
                    时间:&nbsp;
                    <time>{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                </div>

                <div class="item">
                    标签:&nbsp;
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                    @endforeach
                </div>

                @can('update', $post)
                    <div class="item">
                        <a title="编辑: {{ $post->heading() }}" target="_blank" href="{{ route('admin.posts.edit', $post->id) }}">编辑</a>
                    </div>
                @endcan
            </div>

            <div class="post-content">{!! $post->content() !!}</div>

        </article>

        <div class="ui divider"></div>

        @include('comments._list', ['collections' => $comments->first(null, [])])
    </div>

    @include('common._sidebar')
</div>
@endsection
