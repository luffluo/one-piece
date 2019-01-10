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
                            <time datetime="{{ $post->created_at->format('c') }}" itemprop="datePublished">{{ $post->created_at->format(setting('post_date_format', 'Y-m-d')) }}</time>
                        </div>

                        @if(count($post->tags))
                            <div class="item">
                                标签:
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                                @endforeach
                            </div>
                        @endif

                        <div class="item" itemprop="interactionCount">
                            <a itemprop="discussionUrl"
                               href="{{ route('posts.show', $post->id) }}#comments">{{ $post->commentsNum('评论', '%d 条评论') }}</a>
                        </div>

                        @can('update', $post)
                            <div class="item">
                                <a title="编辑: {{ $post->headline() }}" target="_blank" href="{{ route('admin.posts.edit', $post->id) }}">编辑</a>
                            </div>
                        @endcan
                    </div>

                    <div class="post-content" itemprop="articleBody">
                        {!! $post->content('- 阅读剩余部分 -') !!}
                    </div>
                </article>
                <div class="ui clearing divider"></div>
            @empty
                <article class="post">
                    <h2 class="ui header">没有找到内容</h2>
                </article>
                <div class="ui clearing divider"></div>
            @endforelse

            {{ $posts->links() }}

        </div>

        @include('common._sidebar')
    </div>

@endsection
