@extends('layouts.app')
@section('title', '页面没找到')

@section('content')
    <div class="col-md-8 col-md-offset-2">

        <div class="error-page">
            <h2 class="post-title">404 - 页面没找到</h2>
            <p>你想查看的页面已被转移或删除了, 要不要搜索看看: </p>
            <form action="{{ route('search') }}" method="get">
                <p><input type="text" name="q" class="text" autofocus /></p>
                <p><button type="submit" class="submit">搜索</button></p>
            </form>
        </div>

    </div><!-- end #content-->
@endsection
