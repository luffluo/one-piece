@extends('layouts.default')

@section('title', '首页')

@section('content')

    @foreach ($posts as $post)
        <div class="post">
            <h2 class="post-title">
                <a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->getTitle() }}</a>
            </h2>
            <p class="post-meta">
                {{ $post->created_at->format('Y-m-d') }}

                <span class="pull-right">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags') . '#' . $tag->slug }}">{{ $tag->name }}</a>
                    @endforeach
                </span>
            </p>

            <div class="post-content">
                {!! $post->content('- 阅读剩余部分 -') !!}
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}
@endsection
