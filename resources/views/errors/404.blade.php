@extends('layouts.app')
@section('title', '页面没找到')

@section('content')
    <div class="column">
        <h2 class="ui header">404 - 页面没找到</h2>
        <p>你想查看的页面已被转移或删除了, 要不要搜索看看: </p>
        <form class="ui form" action="{{ route('search') }}" method="get">
            <p><input type="text" name="q" class="text" autofocus></p>
            <p><button type="submit" class="ui button">搜索</button></p>
        </form>
    </div>
@endsection
