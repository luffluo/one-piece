@extends('layouts.main')

@section('title', '首页')

@section('content')

    @foreach ($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title">{{ $post->title }}</h2>
            <p class="blog-post-meta">{{ $post->created_at->format('Y-m-d') }} <a href="#">Luff</a></p>
            <p>{{ str_limit($post->text, 99) }}</p>
            <p class="pull-right"><a href="#" class="btn btn-default" role="button">Read More &gt;&gt;</a></p>
        </div>
    @endforeach

    {{ $posts->links() }}
@endsection
