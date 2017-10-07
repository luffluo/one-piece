@extends('layouts.default')

@section('title', isset($title) && !empty($title) ? $title : '首页')

@section('content')
    @if (count(sidebar_block()) > 0)
        <div id="main" class="col-md-8 main" role="main">
    @else
        <div id="main" class="col-md-8 col-md-offset-2" role="main">
    @endif

        @if (isset($search) && ! empty($search))
            <h3 class="archive-title">包含关键字 {{ $search }} 的文章</h3>
        @endif

        @if (isset($title) && !empty($title))
            <h3 class="archive-title">{{ $title }}</h3>
        @endif

        @if (isset($tag) && !empty($tag))
            <h3 class="archive-title">标签 {{ $tag->name }} 下的文章</h3>
        @endif

        @forelse ($posts as $post)
            <article class="post">
                <h2 class="post-title" itemprop="name headline">
                    <a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->headline() }}</a>
                </h2>
                <ul class="post-meta">
                    <li>
                        <time>{{ $post->created_at->format(option('post_date_format', 'Y-m-d')) }}</time>
                    </li>

                    @if(count($post->tags))
                    <li>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (!$loop->last),&nbsp;@endif
                        @endforeach
                    </li>
                    @endif

                    <li itemprop="interactionCount">
                        <a itemprop="discussionUrl" href="{{ route('post.show', $post->id) }}#comments">{{ $post->commentsNum('评论', '%d 评论') }}</a>
                    </li>
                </ul>

                <div class="post-content" itemprop="articleBody">
                    {!! $post->content('- 阅读剩余部分 -') !!}
                </div>
            </article>
        @empty
            <article class="post">
                <h2 class="post-title">没有找到内容</h2>
            </article>
        @endforelse

        {{ $posts->links() }}

    </div>

    @include('common.sidebar')

@endsection
