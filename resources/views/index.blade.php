@extends('layouts.main')

@section('title', '首页')

@section('content')

    @foreach ($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title">
                <a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h2>
            <p class="blog-post-meta">{{ $post->created_at->format('Y-m-d') }} <a href="#">Luff</a></p>
            <p>{!! $parser->makeHtml(str_limit($post->text, 99)) !!}</p>
            <p class="pull-right">
                <a href="{{ route('post.show', ['post' => $post->id]) }}" class="btn btn-default" role="button">Read More &gt;&gt;</a>
            </p>
        </div>
    @endforeach

    {{ $posts->links() }}
@endsection
