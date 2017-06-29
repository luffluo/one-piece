@extends('layouts.main')

@section('title', '首页')

@section('content')

    @foreach ($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title">
                <a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->title() }}</a>
            </h2>
            <p class="blog-post-meta">
                {{ $post->created_at->format('Y-m-d') }}

                <span class="pull-right">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags') . '#' . $tag->slug }}">{{ $tag->name }}</a>
                    @endforeach
                </span>
            </p>

            <div class="post-content">
                {!! $post->content('Read More') !!}
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}
@endsection
