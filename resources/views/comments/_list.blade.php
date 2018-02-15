<div id="comments" class="ui threaded comments">

    <h3 class="ui header">{{ $post->commentsNum('暂无评论', '仅有一条评论', '已有 %d 条评论') }}</h3>

    @if(count($collections) > 0)
        @foreach($collections as $comment)
            @include('comments._comment', ['comment' => $comment])
        @endforeach
    @endif

    @if($post->allow_comment)
    <div id="respond-post-{{ $post->id }}" class="respond">

        <div class="cancel-comment-reply ui right floated list">
            <a id="cancel-comment-reply-link" class="item" href="{{ route('posts.show', $post->id) }}#respond-post-{{ $post->id }}" rel="nofollow" style="display:none" onclick="return OPComment.cancelReply();">取消回复</a>
        </div>

        <h3 id="response" class="ui header">添加新评论</h3>

        <form class="ui reply form" method="post" action="{{ route('comments.store') }}" id="comment-form" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            @auth
                <p>
                    登录身份: {{ auth()->user()->showName() }}.
                    <a href="{{ route('logout') }}" data-method="post" data-confirm="确定要退出吗？" title="Logout">
                        退出 <i class="angle double right icon"></i>
                    </a>
                </p>
            @else
                <p><a href="{{ route('login') }}" title="Login">登录</a>后评论</p>
            @endauth

            <p class="field">
                <textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required></textarea>
            </p>

            <p>
                <button type="submit" class="ui basic button">提交评论</button>
            </p>
        </form>
    </div>
    @else
        <h3>评论已关闭</h3>
    @endif
</div>

@section('script-inner')
    @parent
    <script>
        (function () {

            'use strict';

            window.OPComment = {

                dom : function (id) {
                    return document.getElementById(id);
                },

                create : function (tag, attr) {
                    let el = document.createElement(tag);

                    for (let key in attr) {
                        el.setAttribute(key, attr[key]);
                    }

                    return el;
                },

                reply : function (cid, coid) {
                    let comments = this.dom('comments'),
                        comment = this.dom(cid), parent = comment.parentNode,
                        response = this.dom('respond-post-{{ $post->id }}'), input = this.dom('comment-parent'),
                        form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                        textarea = response.getElementsByTagName('textarea')[0],
                        dividerLine = this.create('div', {
                            'class': 'ui divider',
                        });

                    $('.ui.divider', comments).remove();

                    if (null == input) {
                        input = this.create('input', {
                            'type' : 'hidden',
                            'name' : 'parent_id',
                            'id' : 'comment-parent',
                        });

                        form.appendChild(input);
                    }

                    input.setAttribute('value', coid);

                    if (null == this.dom('comment-form-place-holder')) {
                        let holder = this.create('div', {
                            'id' : 'comment-form-place-holder'
                        });

                        response.parentNode.insertBefore(holder, response);
                    }
                    comment.appendChild(dividerLine);
                    comment.appendChild(response);

                    this.dom('cancel-comment-reply-link').style.display = '';

                    if (null != textarea && 'text' == textarea.name) {
                        textarea.focus();
                    }

                    return false;
                },

                cancelReply : function () {
                    let response = this.dom('respond-post-{{ $post->id }}'),
                        responseParentNode = response.parentNode,
                        holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

                    responseParentNode.removeChild(response.previousElementSibling);

                    if (null != input) {
                        input.parentNode.removeChild(input);
                    }

                    if (null == holder) {
                        return true;
                    }

                    this.dom('cancel-comment-reply-link').style.display = 'none';
                    holder.parentNode.insertBefore(response, holder);

                    return false;
                },

            };
        })();
    </script>
@endsection
