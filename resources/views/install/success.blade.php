@extends('layouts.install')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h2>安装成功!</h2>

            <div class="row">
                <div class="col-md-12">
                    <p class="bg-success" style="padding: 10px;">您的用户名是: <strong>{{ $username }}</strong>
                        <br>
                        您的密码是: <strong>{{ $password }}</strong>
                    </p>
                </div>
            </div>

            <div>
                <p>您可以将下面两个链接保存到您的收藏夹:</p>
                <ul>
                    <li><a target="_blank" href="{{ route('home') }}">点击这里查看您的 Blog</a></li>
                    <li><a target="_blank" href="{{ route('admin.home') }}">点击这里访问您的控制面板</a></li>
                </ul>
            </div>

            <p>希望您能尽情享用 Luff 带来的乐趣!</p>
        </div>
    </div>
@endsection