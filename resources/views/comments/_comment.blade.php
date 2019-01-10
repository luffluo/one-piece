<div id="comment-{{ $comment->id }}" class="comment comment-body{{ $comment->liClass() }}" itemscope="" itemtype="http://schema.org/UserComments">

    <a href="{{ route('users.center', $comment->user->name) }}" class="avatar" alt="{{ $comment->user->showName() }}" itemprop="creator" itemscope="" itemtype="http://schema.org/Person">
        <span itemprop="image">
            <img src="{{ $comment->user->showAvatar() }}" alt="{{ $comment->user->showName() }}">
        </span>
    </a>

    <div class="content">
        <span class="author" itemprop="creator" itemscope="" itemtype="http://schema.org/Person">
            <cite itemprop="name">
                <a class="author" href="{{ route('users.center', $comment->user->name) }}" alt="{{ $comment->user->showName() }}" rel="external nofollow">
                    {{ $comment->user->showName() }}
                </a>
            </cite>
        </span>

        <div class="metadata">
            <a href="{{ route('posts.show', $comment->content_id) . '#comment-' . $comment->id }}">
                <time class="date" itemprop="commentTime" datetime="{{ $comment->created_at->format('c') }}">{{ $comment->created_at->format(setting('comment_date_format')) }}</time>
            </a>
        </div>

        <div class="text" itemprop="commentText">
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