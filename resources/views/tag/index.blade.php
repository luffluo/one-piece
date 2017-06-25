@extends('layouts.main')

@section('title', '标签云')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-tags"></span>&nbsp;Tags</h3>
        </div>
        <div class="panel-body">
            @foreach ($tags as $tag)
                <a class="btn btn-success" href="#{{ $tag->slug }}">{{ $tag->name }}&nbsp;<span class="badge">{{ $tag->count }}</span></a>
            @endforeach

            <hr>

            <div class="archive">
                @foreach ($tags as $tag)
                    <h4 id="{{ $tag->slug }}">{{ $tag->name }}</h4>
                    <ul>
                        @foreach ($tag->posts as $post)
                            <li><a href="{{ route('post.show', ['id' => $post->id]) }}">{{ $post->title }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection