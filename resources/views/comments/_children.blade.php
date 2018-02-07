<div class="comments" itemprop="discusses">
    @foreach($collections as $comment)
        @include('comments._comment', ['comment' => $comment])
    @endforeach
</div>