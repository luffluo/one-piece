@extends('admin::layouts.layout')
@section('title')网站概要@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-lined">
                        <div class="panel-heading"><h4>概要</h4></div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        目前有 <em>{{ $posts_count }}</em> 篇文章, 在 <em>{{ $tags_count }}</em> 个标签中.
                                        <br>
                                        点击下面的链接快速开始:
                                    </p>

                                    <ul class="list-inline">
                                        <li><a href="{{ route('admin.posts.create') }}">撰写新文章</a></li>
                                        <li><a href="{{ route('admin.options.index') }}">系统设置</a></li>
                                    </ul>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <h5>最近发布的文章</h5>
                                    <ul class="list-unstyled">
                                        @foreach($posts as $post)
                                        <li>
                                            <span>{{ $post->created_at->format('n.j') }}</span>
                                            <a target="_blank" href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection