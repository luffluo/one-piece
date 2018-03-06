@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div id="article" class="row">
    <div id="main" class="eleven wide column" role="main">
        <article class="post" itemscope="" itemtype="http://schema.org/BlogPosting">

            <h1 class="ui sub header" itemprop="name headline">
                <a itemprop="url" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->headline() }}</a>
            </h1>

            <div class="ui small horizontal divided list">
                <div itemprop="author" itemscope="" itemtype="http://schema.org/Person" class="item">
                    作者:
                    <span itemprop="name" rel="author">{{ $post->user->showName() }}</span>
                </div>

                <div class="item">
                    时间:
                    <time datetime="{{ $post->created_at->format('c') }}" itemprop="datePublished">{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                </div>

                <div class="item">
                    标签:
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                    @endforeach
                </div>

                @can('update', $post)
                    <div class="item">
                        <a title="编辑: {{ $post->headline() }}" target="_blank" href="{{ route('admin.posts.edit', $post->id) }}">编辑</a>
                    </div>
                @endcan
            </div>

            <div class="post-content" itemprop="articleBody">{!! $post->content() !!}</div>

        </article>

        <div class="ui divider"></div>

        @include('comments._list', ['collections' => $comments->first(null, [])])
    </div>

    @include('common._sidebar')
</div>
@endsection
