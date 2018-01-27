@extends('layouts.app')

@section('title', $user->showName())

@section('content')
    <div class="col-md-3">
        <div class="thumbnail">
            <img alt="用户头像" src="{{ $user->showAvatar() }}" data-holder-rendered="true" width="250px" height="250px">
            <div class="caption">
                <div class="user-name">
                    <h3 style="display: inline-block">
                        {{ $user->showName() }}
                    </h3>

                    @if ($user->isOnline())
                        &nbsp;<span class="fa fa-circle" style="color: #0d9f47;" title="在线"> </span>
                    @else
                        &nbsp;<span class="fa fa-circle" style="color: gray;" title="离线"> </span>
                    @endif
                </div>

                <p>{{ $user->introduction() }}</p>

                <hr>
                <p>
                    <span>最后登录于: </span>
                    <span>{{ $user->logged_at->diffForHumans() }}</span>
                </p>

                @can('update', $user)
                    <hr>
                    <p>
                        <a href="{{ route('users.edit_profile', $user->name) }}" class="btn btn-info btn-sm" style="display: block">
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

                        <a target="_blank" href="{{ route('posts.show', $comment->post->id) }}"
                           title="{{ $comment->post->headline() }}" class="remove-padding-left">
                            {{ $comment->post->headline() }}
                        </a>
                        <span class="meta">at
                            <span class="timeago" title="{{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}">
                                {{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}
                            </span>
                        </span>

                        <div class="reply-body markdown-reply content-body">
                            {!! $comment->content() !!}
                        </div>

                        <div class="comment-button clearfix">
                            <a class="pull-right" href="{{ route('comments.destroy', [$comment->id]) }}" data-method="delete" data-confirm="确定要删除吗？">删除</a>
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