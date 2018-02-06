@extends('admin::layouts.app')
@section('title')
    @if(isset($cid) && $post)
        {{ $post->headline() . ' 的评论' }}
    @else
        管理评论
    @endif
@endsection

@section('content')
    <div class="ui header">
        <h3>
            @yield('title')
        </h3>
    </div>

    <div class="ui content">

        @include('admin::common.message')

        <table class="ui very basic selectable table">
            <thead>
            <tr>
                <th class="five wide">作者</th>
                <th class="eleven wide">内容</th>
            </tr>
            </thead>

            <tbody>
            @forelse ($lists as $list)
                <tr id="comment-{{ $list->id }}" data-comment="{{ collect([
                                'author' => $list->user->name,
                                'email' => $list->user->email,
                                'type' => $list->type,
                                'text' => $list->text
                            ])->toJson() }}">
                    <td valign="top" class="comment-head">
                        <div class="comment-meta">
                            <strong class="comment-author">
                                <a href="#" rel="external nofollow" target="_blank">{{ $list->user->name }}</a>
                            </strong>
                            @if($list->user->email)
                                <br><span>
                                            <a href="mailto:{{ $list->user->email }}"
                                               target="_blank">{{ $list->user->email }}</a>
                                        </span>
                            @endif
                        </div>
                    </td>

                    <td valign="top" class="comment-body">
                        <div class="comment-date">{{ $list->created_at->diffForHumans() }} 于 <a
                                    href="{{ route('posts.show', $list->content_id) }}#comment-{{ $list->id }}"
                                    target="_blank">{{ $list->post->headline() }}</a></div>
                        <div class="comment-content">
                            {{ $list->text }}
                        </div>
                        <div class="comment-action hidden-by-mouse">
                            {{--<span class="weak">通过</span>--}}

                            {{--<a href="action/comments-edit?do=waiting&amp;coid=6&amp;_=ec9ab78cf5ef60f03dd88643aa669a68" class="operate-waiting">待审核</a>--}}

                            {{--<a href="action/comments-edit?do=spam&amp;coid=6&amp;_=ec9ab78cf5ef60f03dd88643aa669a68" class="operate-spam">垃圾</a>--}}

                            <a href="#comment-{{ $list->id }}"
                               rel="{{ route('admin.comments.update', $list->id) }}" class="operate-edit">编辑</a>

                            <a href="#comment-{{ $list->id }}" rel="{{ route('admin.comments.reply', $list->id) }}" class="operate-reply">回复</a>

                            <a ref="#comment-{{ $list->id }}" href="{{  route('admin.comments.destroy', $list->id) }}" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="2">没有评论</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="ui buttons">
            {{ $lists->appends(['cid' => $cid])->links() }}
        </div>
    </div>
@endsection

@section('script-inner')
    @parent
    <script>
        $(document).ready(function () {
            'use strict';

            $(document).on('click', '.operate-edit', function () {

                let tr = $(this).parents('tr'), oldTd = $(this).parents('td'), t = $(this), id = tr.attr('id'), comment = tr.data('comment');

                oldTd.hide();

                let edit = $('<td valign="top">'
                    + '<form method="post" action="' + t.attr('rel') + '" class="ui form comment-edit-content">'
                    + '<input type="hidden" name="_method" value="patch">'
                    + '<p><textarea name="text" id="' + id + '-text" rows="6"></textarea></p>'
                    + '<p><button type="submit" class="ui compact mini primary button">提交</button> '
                    + '<button type="button" class="ui compact mini button cancel">取消</button></p>'
                    + '</form></td>')
                    .insertAfter(oldTd);

                $('textarea[name=text]', edit).val(comment.text).focus();

                $('.cancel', edit).click(function () {
                    let td = $(this).parents('td');

                    $(oldTd).show();

                    td.remove();
                });

                $('form', edit).submit(function () {
                    let t = $(this), td = t.parents('td'), oldTd = td.prev();

                    $('.comment-content', oldTd).html('<p>' + $('textarea[name=text]', form).val() + '</p>');

                    $.post(t.attr('action'), t.serialize(), function (o) {
                        $('.comment-content', oldTd).html('<p>' + o.comment.text + '</p>').effect('highlight');
                    }, 'json');

                    oldTd.show();
                    td.remove();

                    return false;
                });

                return false;
            });

            $(document).on('click', '.operate-reply', function () {

                let td = $(this).parents('td'), t = $(this);

                let form = $('<form method="post" action="' + t.attr('rel') + '" class="ui form comment-reply">'
                    + '<p><label for="text">内容</label><textarea id="text" name="text" rows="3"></textarea></p>'
                    + '<p><button type="submit" class="ui compact mini primary button">回复</button> <button type="button" class="ui compact mini button cancel">取消</button></p>'
                    + '</form>').insertBefore($('.comment-action', td));

                $('.cancel', form).click(function () {
                    $(this).parents('.comment-reply').remove();
                });

                let textarea = $('textarea', form).focus();

                form.submit(function () {

                    let t = $(this), tr = t.parents('tr'),
                        reply = $('<div class="comment-reply-content"></div>').insertAfter($('.comment-content', tr));

                    reply.html('<p>' + textarea.val() + '</p>');

                    $.post(t.attr('action'), t.serialize(), function (o) {
                        reply.html('<p>' + o.comment.text + '</p>').effect('highlight');
                    }, 'json');

                    form.remove();

                    return false;
                });

                return false;
            });
        });
    </script>
@endsection