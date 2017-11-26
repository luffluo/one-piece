<div class="comment-children" itemprop="discusses">
    <ol class="comment-list">
        @foreach($collections as $comment)
            @include('comments._comment', ['comment' => $comment])
        @endforeach
    </ol>
</div>