@extends('layouts.app')

@section('title', $user->showName())

@section('content')
    <div class="row">
        <div class="four wide column">
            <div class="ui card">
                <div class="image">
                    <img alt="用户头像" src="{{ $user->showAvatar() }}" data-holder-rendered="true">
                </div>
                <div class="content">
                    <h3 class="header">
                        {{ $user->showName() }}
                    </h3>
                    <div class="meta">
                        <span class="date">{{ $user->created_at->diffForHumans() }} 加入</span>
                    </div>

                    <div class="description">{{ $user->introduction() }}</div>
                </div>

                <div class="extra content">
                    @if ($user->isOnline())
                        &nbsp;<i class="user icon" style="color: #0d9f47;" title="在线"></i>
                    @else
                        &nbsp;<i class="user icon" style="color: gray;" title="离线"></i>
                    @endif
                        <span class="date right floated">最后登录于 {{ $user->logged_at->diffForHumans() }}</span>
                </div>

                @can('update', $user)
                    <div class="extra content">
                        <a href="{{ route('users.edit_profile', $user->name) }}" class="ui fluid default button">
                            编辑个人信息
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div id="main" class="settings twelve wide column">
                <div class="ui header">
                    <h3>最近评论</h3>
                </div>

                <div class="ui divider"></div>

                <div class="content">
                    <div class="ui divided items">
                        @forelse($comments as $comment)
                            <div class="item hovered actions">
                                <div class="content">
                                    <div class="meta">
                                        <a target="_blank" href="{{ route('posts.show', $comment->post->id) }}"
                                           title="{{ $comment->post->heading() }}" class="remove-padding-left">
                                            {{ $comment->post->heading() }}
                                        </a>
                                        <span class="date" title="{{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}">
                                            {{ $comment->created_at->format(option('comment_date_format', 'Y-m-d H:i:s')) }}
                                        </span>
                                    </div>
                                    <div class="description">
                                        {!! $comment->content() !!}
                                    </div>

                                    <div class="extra actions">
                                        <div class="ui right floated horizontal list">
                                            <a class="item" href="{{ route('comments.destroy', [$comment->id]) }}" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h5 class="item">没有任何评论</h5>
                        @endforelse
                    </div>

                    {!! $comments->links() !!}
                </div>
            </div>
    </div>
@endsection