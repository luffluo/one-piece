@extends('admin::layouts.app')
@section('title')网站概要@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap luff-dashboard">
            <div class="panel panel-lined">
                <div class="panel-heading"><h4>概要</h4></div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                目前有 <em class="lead">{{ $posts_count }}</em> 篇文章, 在 <em class="lead">{{ $tags_count }}</em> 个标签中.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>点击下面的链接快速开始:</p>
                            <ul class="list-inline" style="margin-left: 0;">
                                <li><a href="{{ route('admin.posts.create') }}">撰写新文章</a></li>
                                <li><a href="{{ route('admin.navs.index') }}">导航设置</a></li>
                                <li><a href="{{ route('admin.themes.option') }}">外观设置</a></li>
                                <li><a href="{{ route('admin.options.reading') }}">阅读设置</a></li>
                                <li><a href="{{ route('admin.options.general') }}">系统设置</a></li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>最近发布的文章</h5>
                            <ul class="list-unstyled latest-link">
                                @forelse($posts as $post)
                                    <li>
                                        <span>{{ $post->created_at->format('n.j') }}</span>
                                        <a title="浏览 {{ $post->headline() }}" target="_blank" href="{{ route('posts.show', $post->id) }}">{{ $post->headline(50) }}</a>
                                    </li>
                                @empty
                                    <li><em>暂时没有文章</em></li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h5>最近得到的回复</h5>
                            <ul class="list-unstyled latest-link">
                                @forelse($comments as $comment)
                                    <li>
                                        <span>{{ $comment->created_at->format('n.j') }}</span>
                                        {{ $comment->user->showName() }}:&nbsp;{{ $comment->text }}
                                    </li>
                                @empty
                                    <li><em>暂时没有回复</em></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection