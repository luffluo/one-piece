<div class="comment-children" itemprop="discusses">
    <ol class="comment-list">
        @foreach($collections as $comment)
            @include('comment._comment', ['comment' => $comment])
        @endforeach
    </ol>
</div>