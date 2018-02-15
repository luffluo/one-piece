<div itemscope="" itemtype="#" id="comment-{{ $comment->id }}" class="comment comment-body{{ $comment->liClass() }}">

    <a href="{{ route('users.center', $comment->user->name) }}" class="avatar" alt="{{ $comment->user->showName() }}">
        <img src="{{ $comment->user->showAvatar() }}" alt="{{ $comment->user->showName() }}">
    </a>

    <div class="content">
        <a href="{{ route('users.center', $comment->user->name) }}" alt="{{ $comment->user->showName() }}" class="author">
            {{ $comment->user->showName() }}
        </a>

        <div class="metadata">
            <span class="date">{{ $comment->created_at->format(option('comment_date_format')) }}</span>
        </div>

        <div class="text">
            {!! $comment->content() !!}
        </div>

        <div class="actions">

            <div class="ui small horizontal divided list">
                @can('delete', $comment)
                    <a class="delete item" href="{{ route('comments.destroy', [$comment->id]) }}" data-method="delete" data-confirm="确定要删除吗？" rel="nofollow">删除</a>
                @endcan

                <a class="reply item" href="{{ route('posts.show', $comment->content_id) . '?replyTo-post-' . $comment->content_id }}" onclick="return OPComment.reply('comment-{{ $comment->id }}', {{ $comment->id }})" rel="nofollow">回复</a>
            </div>
        </div>
    </div>

    @if(isset($comments[$comment->id]) && count($comments[$comment->id]) > 0)
        @include('comments._children', ['collections' => $comments[$comment->id]])
    @endif
</div>