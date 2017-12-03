<li itemscope="" itemtype="#" id="comment-{{ $comment->id }}" class="comment-body{{ $comment->liClass() }}">
    <div class="comment-author" itemprop="creator" itemscope="" itemtype="#">
        <span itemprop="image">
            <img class="avatar" src="{{ $comment->user->showAvatar() }}" alt="{{ $comment->user->showName() }}" height="32" width="32">
        </span>
        <cite class="fn" itemprop="name">{{ $comment->user->showName() }}</cite>
    </div>

    <div class="comment-meta">
        <a href="{{ route('posts.show', $comment->content_id) . '#comment-' . $comment->id }}">
            <time itemprop="commentTime" datetime="">{{ $comment->created_at->format(option('comment_date_format')) }}</time></a>
    </div>

    <div class="comment-content" itemprop="commentText">
        {{ $comment->text }}
    </div>

    <div class="comment-reply">

        @can('delete', $comment)
        <a rel="nofollow" href="{{ route('comments.destroy', [$comment->id]) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form').submit();">删除</a>

        |
            <form id="comment-delete-form" action="{{ route('comments.destroy', [$comment->id]) }}" method="post" style="display: none;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            </form>
        @endcan

        <a href="{{ route('posts.show', $comment->content_id) . '?replyTo-post-' . $comment->content_id }}" onclick="return LuffComment.reply('comment-{{ $comment->id }}', {{ $comment->id }})" rel="nofollow">回复</a>

    </div>

    @if(isset($comments[$comment->id]) && count($comments[$comment->id]) > 0)
        @include('comments._children', ['collections' => $comments[$comment->id]])
    @endif
</li>