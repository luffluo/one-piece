@extends('admin::layouts.app')
@section('title', '网站概要')
@section('content')

    <div class="row">
        <h3 class="ui header">概要</h3>
    </div>

    <div class="ui container">
        <div class="statistics">
            <div class="ui horizontal statistic">
                <div class="label">目前有</div>
                <div class="value">{{ $posts_count }}</div>
                <div class="label"> 篇文章,</div>
            </div>
            <div class="ui horizontal statistic">
                <div class="label">在</div>
                <div class="value">{{ $tags_count }}</div>
                <div class="label">个标签中.</div>
            </div>
        </div>

        <p class="sub header">点击下面的链接快速开始:</p>

        <div class="ui secondary large stackable menu">
            <a class="item" href="{{ route('admin.posts.create') }}">撰写新文章</a>
            <a class="item" href="{{ route('admin.navs.index') }}">导航设置</a>
            <a class="item" href="{{ route('admin.themes.option') }}">外观设置</a>
            <a class="item" href="{{ route('admin.options.reading') }}">阅读设置</a>
            <a class="item" href="{{ route('admin.options.general') }}">系统设置</a>
        </div>

        <div class="ui inverted section divider"></div>

        <div class="ui two column stackable grid">
            <div class="column">
                <h5>最近发布的文章</h5>
                <div class="ui list">
                    @forelse($posts as $post)
                        <div class="item">
                            <div class="ui small horizontal divided list">
                                <div class="item">{{ $post->created_at->format('n.j') }}</div>
                                <div class="item">
                                    <a title="浏览 {{ $post->headline() }}" target="_blank" href="{{ route('posts.show', $post->id) }}">{{ $post->headline(50) }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="item"><em>暂时没有文章</em></div>
                    @endforelse
                </div>
            </div>

            <div class="column">
                <h5>最近得到的回复</h5>
                <div class="ui list">
                    @forelse($comments as $comment)
                        <div class="item">
                            <div class="ui small horizontal divided list">
                                <div class="item">{{ $comment->created_at->format('n.j') }}</div>
                                <div class="item">
                                    <a title="{{ $comment->user->showName() }}" href="{{ route('users.center', [$comment->user->name]) }}" target="_blank">
                                        {{ $comment->user->showName() }}
                                    </a>
                                    :&nbsp;{{ strip_tags($comment->content()) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="item"><em>暂时没有回复</em></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection