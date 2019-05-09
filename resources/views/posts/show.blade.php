@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div id="article" class="row">

    <div class="three wide column">
        <div id="article-directory" class="ui top sticky">
        </div>
    </div>

    <div id="main" class="ten wide column" role="main">

        <article class="post" itemscope="" itemtype="http://schema.org/BlogPosting">

            <h1 class="ui sub header" itemprop="name headline">
                <a itemprop="url" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->headline() }}</a>
            </h1>

            <div class="ui small horizontal divided list">
                <div itemprop="author" itemscope="" itemtype="http://schema.org/Person" class="item">
                    作者:
                    <span itemprop="name" rel="author">{{ $post->user->showName() }}</span>
                </div>

                <div class="item">
                    时间:
                    <time datetime="{{ $post->created_at->format('c') }}" itemprop="datePublished">{{ $post->created_at->format(setting('post_date_format', 'Y-m-d')) }}</time>
                </div>

                <div class="item">
                    标签:
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a>@if (! $loop->last),&nbsp;@endif
                    @endforeach
                </div>

                @can('update', $post)
                    <div class="item">
                        <a title="编辑: {{ $post->headline() }}" target="_blank" href="{{ route('admin.posts.edit', $post->id) }}">编辑</a>
                    </div>
                @endcan
            </div>

            <div class="post-content" itemprop="articleBody">{!! $post->content() !!}</div>

        </article>

        <div class="ui divider"></div>

        @include('comments._list', ['collections' => $comments->first(null, [])])
    </div>

    @include('common._sidebar')
</div>
@endsection

@section('css')
    @parent
    <style>
        #article-directory .ui.list .list, #article-directory ol.ui.list ol, #article-directory ul.ui.list ul {
            padding-left: .9em;
        }
    </style>
@endsection

@section('script-inner')
    @parent

    <script>

        'use strict';

        $(function () {
            articleIndex();

            $('.ui.top.sticky').sticky({
                silent: true,
                context: '.post',
            });
        });

        // 生成index
        function articleIndex() {

            var $article = $('#main article .post-content');
            var $header = $article.find('h1, h2, h3');
            var _html = '<div id="articleIndex" class="ui list"></div>';
            $('#article-directory').append(_html);

            var _tagLevel = 1;                  // 最初的level
            var _$wrap = $('#articleIndex');    // 最初的wrap

            $header.each(function(index) {

                // 空的title
                if ($(this).text().trim() === '') {
                    return;
                }

                // 加id
                $(this).attr('id', 'articleHeader' + index);

                // 当前的 tagLevel
                var _tl = parseInt($(this)[0].tagName.slice(1));
                var _tlNext = null;
                if ($header[index+1]) {
                    _tlNext = parseInt($($header[index+1])[0].tagName.slice(1));
                }

                var _$li = null;
                if (_tl === _tagLevel && _tlNext === _tl) {  // 是与上一个相同
                    _$li = $('<div class="item"><a class="link" href="#articleHeader'+ index +'">' + $(this).text() + '</a></div>');
                    _$wrap.append(_$li);
                } else if (_tlNext && _tlNext > _tl) {  // 当前的大于上次的
                    _$li = $('<div class="item"><a class="link" href="#articleHeader' + index + '">' + $(this).text() + '</a><div class="list"></div></div>');
                    _$wrap.append(_$li);
                    _$wrap = _$li.find('div[class=list]');

                } else if (_tl < _tagLevel || _tl >= _tagLevel) {    // 当前的小于上次的

                    _$li = $('<div class="item"><a class="link" href="#articleHeader'+ index +'">' + $(this).text() + '</a></div>');

                    if (1 === _tl) {

                        $('#articleIndex').append(_$li);
                        _$wrap = $('#articleIndex');

                    } else if (3 === _tagLevel && _tagLevel > _tl) {
                        _$wrap = _$wrap.parent();
                        _$wrap.append(_$li);

                    } else {
                        _$wrap.append(_$li);
                    }
                }
                _tagLevel = _tl;
            });
        }
    </script>
@endsection
