@extends('layouts.app')

@section('title', '标签云')

@section('content')
    <div class="row">
        <div class="eleven wide column">
            <div class="ui basic segment">
                <div class="ui header">
                    <h3><i class="tags icon"></i>Tags</h3>
                </div>
                <div class="ui divider"></div>

                <div class="content">

                    <div class="ui basic segment">
                        <div class="ui small labels">
                            @foreach ($tags as $tag)
                                <a class="ui basic label" href="#{{ $tag->slug }}">
                                    {{ $tag->name }}
                                    <div class="ui mini circular label">{{ $tag->count }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="ui divider"></div>

                    <div class="ui basic segment">
                        @foreach ($tags as $tag)
                            <h4 class="ui header" id="{{ $tag->slug }}">{{ $tag->name }}</h4>
                            <ul class="ui list">
                                @foreach ($tag->posts as $post)
                                    <li class="item">
                                        <a href="{{ route('posts.show', ['id' => $post->id]) }}">{{ $post->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @include('common._sidebar')
    </div>

@endsection