@extends('layouts.default')

@section('title', $user->displayName())

@section('content')
    <div class="col-md-3">
        <div class="thumbnail">
            <img data-src="holder.js/100%x200" alt="100%x200" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVmMTk2MDEyMjkgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWYxOTYwMTIyOSI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTkzNzUiIHk9IjEwNS4xIj4yNDJ4MjAwPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
            <div class="caption">
                <h3>{{ $user->displayName() }}</h3>
                <p>执子之手，与子偕老.</p>
                <hr>
                <p>最后登录: 1 天前</p>
                @if(auth()->check() && $user->id === auth()->user()->id)
                    <hr>
                    <p>
                        <a href="{{ route('user.edit_profile', $user->name) }}" class="btn btn-info btn-sm" style="display: block">
                            <i class="fa fa-edit"> </i>
                            编辑个人信息
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div id="main" class="settings col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最近评论</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    @forelse($comments as $comment)
                    <li class="list-group-item">

                        <a target="_blank" href="{{ route('post.show', $comment->post->id) }}"
                           title="{{ $comment->post->headline() }}" class="remove-padding-left">
                            {{ $comment->post->headline() }}
                        </a>
                        <span class="meta">at
                            <span class="timeago" title="{{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}">
                                {{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}
                            </span>
                        </span>

                        <div class="reply-body markdown-reply content-body">
                            {{ $comment->content() }}
                        </div>
                    </li>
                    @empty
                        <h5>没有任何评论</h5>
                    @endforelse
                </ul>

                <div class="page">
                    {!! $comments->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection