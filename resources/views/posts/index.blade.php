@extends('layouts.app')

@section('title', isset($title) && !empty($title) ? $title : '首页')

@section('content')

    <div id="article" class="row">
        <div id="main" class="eleven wide column" role="main">
            @if (isset($search) && ! empty($search))
                <h3 class="ui disabled small header">包含关键字 {{ $search }} 的文章</h3>
            @endif

            @if (isset($title) && !empty($title))
                <h3 class="ui disabled small header">{{ $title }}</h3>
            @endif

            @if (isset($tag) && !empty($tag))
                <h3 class="ui disabled small header">标签 {{ $tag->name }} 下的文章</h3>
            @endif

            @forelse ($posts as $post)
                <article class="post">
                    <h2 class="ui sub header" itemprop="name headline">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->heading() }}</a>
                    </h2>
                    <div class="ui small horizontal divided list">
                        <div class="item">
                            <time>{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                        </div>

                        @if(count($post->tags))
                            <div class="item">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('tags.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                                @endforeach
                            </div>
                        @endif

                        <div class="item" itemprop="interactionCount">
                            <a itemprop="discussionUrl"
                               href="{{ route('posts.show', $post->id) }}#comments">{{ $post->commentsNum('评论', '%d 条评论') }}</a>
                        </div>
                    </div>

                    {{--<div class="ui hidden divider"></div>--}}

                    <div class="post-content" itemprop="articleBody">
                        {!! $post->content('- 阅读剩余部分 -') !!}
                    </div>
                </article>
                <div class="ui clearing divider"></div>
            @empty
                <article class="post">
                    <h2 class="ui disabled header">没有找到内容</h2>
                </article>
                <div class="ui clearing divider"></div>
            @endforelse

            {{ $posts->links() }}

        </div>

        @include('common._sidebar')
    </div>

@endsection
