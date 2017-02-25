@extends('admin::layouts.layout')
@section('title')首页@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li><a href="{{ url('admin') }}">仪表盘</a></li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20"><i>仪表盘</i></div>
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="col-md-4 text-right"><strong>Notadd CMS版本：</strong></td>
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