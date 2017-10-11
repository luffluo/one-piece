<li itemscope="" itemtype="#" id="comment-{{ $comment->id }}" class="comment-body{{ $comment->liClass() }}">
    <div class="comment-author" itemprop="creator" itemscope="" itemtype="#">
        <span itemprop="image">
            <img class="avatar" src="http://www.gravatar.com/avatar/?s=32&amp;r=G&amp;d=" alt="{{ $comment->user->displayName() }}" height="32" width="32">
        </span>
        <cite class="fn" itemprop="name">{{ $comment->user->displayName() }}</cite>
    </div>

    <div class="comment-meta">
        <a href="{{ route('post.show', $comment->content_id) . '#comment-' . $comment->id }}">
            <time itemprop="commentTime" datetime="">{{ $comment->created_at->format(option('comment_date_format')) }}</time></a>
    </div>

    <div class="comment-content" itemprop="commentText">
        {{ $comment->text }}
    </div>

    <div class="comment-reply">
        <a href="{{ route('post.show', $comment->content_id) . '?replyTo-post-' . $comment->content_id }}" onclick="return LuffComment.reply('comment-{{ $comment->id }}', {{ $comment->id }})" rel="nofollow">回复</a>
    </div>

    @if(isset($comments[$comment->id]) && count($comments[$comment->id]) > 0)
        @include('comment._children', ['collections' => $comments[$comment->id]])
    @endif
</li>