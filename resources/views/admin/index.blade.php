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
                                            <span>{{ $post->created_at->format('j.d') }}</span>
                                            <a target="_blank" href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{--<div class="col-md-4">--}}
                                    {{--共 <a href="{{ route('admin.tags.index') }}">{{ $tags_count }}</a> 个标签--}}
                                {{--</div>--}}

                                {{--<div class="col-md-4">--}}
                                    {{--共 <a href="{{ route('admin.users.index') }}">{{ $users_count }}</a> 个用户--}}
                                {{--</div>--}}
                            </div>
                        </div>

                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="col-md-4 text-right"><strong>Luff CMS版本：</strong></td>
                                <td class="col-md-8">{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <td class="col-md-4 text-right"><strong>当前时间：</strong></td>
                                <td class="col-md-8">{{ \Carbon\Carbon::now() }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>服务器操作系统：</strong></td>
                                <td>
                                    <?php
                                    $os = explode(" ", php_uname());
                                    echo $os[0];
                                    ?> &nbsp;内核版本：<?php
                                    if('/' == DIRECTORY_SEPARATOR) {
                                        echo $os[2];
                                    } else {
                                        echo $os[1];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>服务器解译引擎：</strong></td>
                                <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>数据库引擎：</strong></td>
                                <td>5.6</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>PHP版本：</strong></td>
                                <td>{{ PHP_VERSION }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>上传文件最大限制：</strong></td>
                                <td>8m(upload_max_filesize) / 2m(post_max_size)</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>开发团队：</strong></td>
                                <td>Luff</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection