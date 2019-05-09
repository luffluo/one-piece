@extends('admin::layouts.app')
@section('title')
    @if(isset($cid) && $post)
        {{ $post->headline() . ' 的评论' }}
    @else
        管理评论
    @endif
@endsection

@section('content')
    <div class="row">
        <h3 class="ui header">
            @yield('title')
        </h3>
    </div>

    <div class="ui container">

        <div class="option-tabs left">
            <div class="ui compact basic tiny buttons" role="group" aria-label="tabs">
                @if (\App\Models\Comment::STATUS_APPROVED === $status)
                    <button class="ui button active">
                        已通过
                    </button>
                @else
                    <a href="{{ route('admin.comments.index', ['status' => \App\Models\Comment::STATUS_APPROVED, 'cid' => $cid]) }}" class="ui button" style="display:flex;display: -webkit-flex;align-items:center;">
                        已通过
                    </a>
                @endif

                @if (\App\Models\Comment::STATUS_WAITING === $status)
                    <button class="ui button active">
                        待审核
                        {!! $waiting_count > 0 ? '&nbsp;<span class="ui compact circular tiny label">' . $waiting_count . '</span>' : '' !!}
                    </button>
                @else
                    <a href="{{ route('admin.comments.index', ['status' => \App\Models\Comment::STATUS_WAITING, 'cid' => $cid]) }}" class="ui button" style="display:flex;display: -webkit-flex;align-items:center;">
                        待审核
                        {!! $waiting_count > 0 ? '&nbsp;<span class="ui compact circular tiny label">' . $waiting_count . '</span>' : '' !!}
                    </a>
                @endif

                @if (\App\Models\Comment::STATUS_SPAM === $status)
                    <button class="ui button active">
                        垃圾
                        {!! $spam_count > 0 ? '&nbsp;<span class="ui compact circular tiny label">' . $spam_count . '</span>' : '' !!}
                    </button>
                @else
                    <a href="{{ route('admin.comments.index', ['status' => \App\Models\Comment::STATUS_SPAM, 'cid' => $cid]) }}" class="ui button" style="display:flex;display: -webkit-flex;align-items:center;">
                        垃圾
                        {!! $spam_count > 0 ? '&nbsp;<span class="ui compact circular tiny label">' . $spam_count . '</span>' : '' !!}
                    </a>
                @endif
            </div>
        </div>

        <div class="search right">
            <form class="ui form" action="{{ route('admin.comments.index') }}" method="get">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="cid" value="{{ $cid }}">
                <div class="fields">

                    @if (! empty($keywords))
                        <div class="field" style="display:flex;display: -webkit-flex;align-items:center;">
                            <a href="{{ route('admin.comments.index', ['status' => $status, 'cid' => $cid]) }}">
                                <i class="angle double left icon" aria-hidden="true"></i>取消筛选
                            </a>
                        </div>
                    @endif

                    <div class="field">
                        <input type="text" name="keywords" value="{{ $keywords }}" placeholder="请输入关键字">
                    </div>

                    <div class="field">
                        <button type="submit" class="ui button">筛选</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="op-list-table ui very basic selectable table">
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
                            <div class="ui basic compact segment" style="padding-left: 0;">
                                {!! $list->content() !!}
                            </div>
                        </div>

                        <div class="comment-action hidden-by-mouse ui horizontal list">

                            @if(\App\Models\Comment::STATUS_APPROVED === $status)
                                <span class="weak item">通过</span>
                            @else
                                <a href="{{ route('admin.comments.change.status', ['comment' => $list->id, 'status' => \App\Models\Comment::STATUS_APPROVED]) }}" data-method="patch" data-confirm="确认要通过评论吗？" class="operate-approved item">通过</a>
                            @endif

                            @if(\App\Models\Comment::STATUS_WAITING === $status)
                                <span class="weak item">待审核</span>
                            @else
                                <a href="{{ route('admin.comments.change.status', ['comment' => $list->id, 'status' => \App\Models\Comment::STATUS_WAITING]) }}"  data-method="patch" data-confirm="确认要标记为待审核吗？" class="operate-waiting item">待审核</a>
                            @endif

                            @if(\App\Models\Comment::STATUS_SPAM === $status)
                                <span class="weak item">垃圾</span>
                            @else
                                <a href="{{ route('admin.comments.change.status', ['comment' => $list->id, 'status' => \App\Models\Comment::STATUS_SPAM]) }}"  data-method="patch" data-confirm="确认要标记为垃圾吗？" class="operate-spam item">垃圾</a>
                            @endif

                            <a href="#comment-{{ $list->id }}"
                               rel="{{ route('admin.comments.update', $list->id) }}" class="operate-edit item">编辑</a>

                            <a href="#comment-{{ $list->id }}" rel="{{ route('admin.comments.store', $list->id) }}" class="operate-reply item">回复</a>

                            <a class="item" ref="#comment-{{ $list->id }}" href="{{  route('admin.comments.destroy', $list->id) }}" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td class="disabled center aligned" colspan="2">没有评论</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $lists->appends(['cid' => $cid])->links() }}
    </div>
@endsection

@section('script-inner')
    @parent
    <script>
        $(document).ready(function () {
            'use strict';

            $('.operate-edit').on('click', function () {

                let tr = $(this).parents('tr'), oldTd = $(this).parents('td'), t = $(this), id = tr.attr('id'), comment = tr.data('comment');

                oldTd.hide();

                let edit = $('<td valign="top">'
                    + '<form method="post" action="' + t.attr('rel') + '" class="ui form comment-edit-content">'
                    + '<input type="hidden" name="_method" value="patch">'
                    + '<div class="field"><textarea name="text" id="' + id + '-text" rows="6"></textarea></div>'
                    + '<div class="field"><button type="submit" class="ui compact tiny primary button">提交</button> '
                    + '<button type="button" class="ui compact tiny button cancel">取消</button></div>'
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

                    // $('.comment-content', oldTd).html('<p>' + $('textarea[name=text]', t).val() + '</p>');

                    $.post(t.attr('action'), t.serialize(), function (o) {
                        $('.comment-content > .ui.segment', oldTd).html(o.comment.text);
                    }, 'json');

                    oldTd.show();
                    td.remove();

                    return false;
                });

                return false;
            });

            $('.operate-reply').on('click', function () {

                let td = $(this).parents('td'), t = $(this);

                if ($('.comment-reply', td).length > 0) {
                    $('.comment-reply').next().remove();
                    $('.comment-reply').remove();
                } else {
                    let form = $('<form method="post" action="' + t.attr('rel') + '" class="ui form comment-reply">'
                        + '<div class="field"><label for="text">内容</label><textarea id="text" name="text" rows="3"></textarea></div>'
                        + '<div class="field"><button type="submit" class="ui compact tiny primary button">回复</button> <button type="button" class="ui compact tiny button cancel">取消</button></div>'
                        + '</form>').insertBefore($('.comment-action', td));
                    let divider = $('<div class="ui hidden divider"></div>').insertAfter(form);

                    $('.cancel', form).click(function () {
                        $(this).parents('.comment-reply').remove();
                        divider.remove();
                    });

                    $('textarea', form).focus();

                    form.submit(function () {

                        let t = $(this), tr = t.parents('tr');
                        var reply = $('<div class="comment-reply-content ui basic segment bg-grey"></div>').insertAfter($('.comment-content', tr));

                        $.post(t.attr('action'), t.serialize(), function (o) {
                            reply.html(o.comment.text);
                        }, 'json');

                        form.remove();
                        divider.remove();

                        return false;
                    });
                }

                return false;
            });
        });
    </script>
@endsection