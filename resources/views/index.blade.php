@extends('layouts.default')

@section('title', '首页')

@section('content')
    @if (isset($search) && ! empty($search))
    <h3>包含关键字 {{ $search }} 的文章</h3>
    @endif

    @forelse ($posts as $post)
        <div class="post">
            <h2 class="post-title">
                <a href="{{ route('post.show', ['post' => $post->id]) }}">{{ $post->getTitle() }}</a>
            </h2>
            <p class="post-meta">
                {{ $post->created_at->format(option('postDateFormat', 'Y-m-d')) }}

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
    @empty
        <div class="post">
            <h2 class="post-title">没有找到内容</h2>
        </div>
    @endforelse

    {{ $posts->links() }}
@endsection
