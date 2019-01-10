@extends('layouts.app')

@section('title', $user->showName())

@section('content')
    <div class="row">
        <div class="four wide column">
            <div class="ui special card">
                @can('update', $user)
                <div class="user blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <a href="{{ route('users.edit_avatar', $user->name) }}" class="ui primary button">上传头像</a>
                            </div>
                        </div>
                    </div>
                    <img alt="用户头像" src="{{ $user->showAvatar() }}" data-holder-rendered="true">
                </div>
                @else
                <div class="image">
                    <img alt="用户头像" src="{{ $user->showAvatar() }}" data-holder-rendered="true">
                </div>
                @endcan

                <div class="content">
                    <div class="header">
                        <span class="ui right floated image">
                            @if ($user->isOnline())
                                <i class="small green user icon" title="在线"></i>
                            @else
                                <i class="small grey user icon" title="离线"></i>
                            @endif
                        </span>
                        {{ $user->showName() }}
                    </div>

                    <div class="meta">
                        <span>{{ $user->created_at->diffForHumans() }}加入</span>
                    </div>

                    <div class="description">{{ $user->introduction }}</div>
                </div>

                <div class="extra content">
                    <span class="date">最后登录于 {{ optional($user->logged_at)->diffForHumans() }}</span>
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
                    @if(count($comments) > 0)
                    <div class="ui divided items">
                        @foreach($comments as $comment)
                            <div class="item hovered actions">
                                <div class="content">
                                    <div class="meta">
                                        <a target="_blank" href="{{ route('posts.show', $comment->post->id) }}"
                                           title="{{ $comment->post->headline() }}" class="remove-padding-left">
                                            {{ $comment->post->headline() }}
                                        </a>
                                        <span class="date" title="{{ $comment->created_at->format(setting('comment_date_format', 'Y-m-d H:i:s')) }}">
                                            {{ $comment->created_at->format(setting('comment_date_format', 'Y-m-d H:i:s')) }}
                                        </span>

                                        @if($comment->isWaiting())
                                            <span class="ui tiny compact label">待审核</span>
                                        @endif

                                        @if($comment->isSpam())
                                            <span class="ui tiny compact label">垃圾</span>
                                        @endif
                                    </div>
                                    <div class="description">
                                        {!! $comment->content() !!}
                                    </div>

                                    <div class="extra actions">
                                        <div class="ui right floated horizontal list">
                                            @can('delete', $comment)
                                            <a class="item" href="{{ route('comments.destroy', [$comment->id]) }}" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="ui tiny disabled centered header">
                        没有任何评论
                    </div>
                    @endif

                    {!! $comments->links() !!}
                </div>
            </div>
    </div>
@endsection

@can('update', $user)
@section('script-inner')
    @parent
    <script>
        $(function () {
            $('.ui.special.card .user.image').dimmer({
                on: 'hover'
            });
        })
    </script>
@endsection
@endcan