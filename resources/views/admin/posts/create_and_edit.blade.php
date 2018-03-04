@extends('admin::layouts.app')
@section('title'){{ $post->exists ? '编辑文章 ' . $post->title : '撰写新文章' }}@endsection

@section('content')
    <div class="row">
        <h3 class="ui header op-page-title">
            @yield('title')
        </h3>
    </div>

    <div id="post-area-container" class="ui container op-post-area">
        @include('common._message')
        @include('common._error')

        <form action="{{ $post->exists ? route('admin.posts.update', [$post->id]) : route('admin.posts.store') }}" class="ui form" enctype="multipart/form-data" method="post">
            @if ($post->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div id="post-area-grid" class="ui two column stackable grid">
                <div id="post-area-left" class="twelve wide column">
                    <div class="field title">
                        <input id="title" type="text" class="text title" style="font-weight: bold;" name="title" placeholder="请输入标题" value="{{ old('title', $post->title) }}" autofocus>
                    </div>

                    <div class="field tags">
                        <select id="tags" class="ui fluid search dropdown" name="tags[]" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option {{ $tag['selected'] ? 'selected' : '' }} value="{{ $tag['value'] }}">
                                    {{ $tag['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="wmd-editarea" class="field">
                        <textarea style="height: 300px" rows="3" autocomplete="off" id="text" name="text" class="mono">{{ old('text', $post->text) }}</textarea>
                    </div>

                    <div class="field submit">
                        <button type="submit" name="do" value="publish" class="ui small primary right floated button">发布文章</button>
                        <button type="submit" name="do" value="save" class="ui small right floated button">保存草稿</button>
                    </div>
                </div>

                <div id="post-area-right" class="four wide column">
                    <div class="tab-content">
                        <div class="field op-post-option">
                            <label>权限控制</label>

                            <div class="grouped fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <input id="allow_comment" name="allow_comment" value="1" {{ $post->allow_comment ? 'checked' : '' }} type="checkbox">
                                        <label for="allow_comment">允许评论</label>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <input id="allow_feed" name="allow_feed" value="1" {{ $post->allow_feed ? 'checked' : '' }} type="checkbox">
                                        <label for="allow_feed">允许在聚合中出现</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($post->exists)
                            <div class="field op-post-option">
                                <div class="row">
                                    <div class="ui hidden divider"></div>
                                    —
                                    <br>
                                    本文由 <span>{{ $post->user->showName() }}</span> 撰写于 {{ $post->created_at->diffForHumans() }}
                                    <br>
                                    最后更新于 {{ $post->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('vendor/hyperdown/hyperdown.js') }}"></script>
    <script src="{{ asset('vendor/pagedown/pagedown.js') }}"></script>
@endsection
@section('script-inner')
    @parent
    <script>
        'use strict';

        $(document).ready(function () {

            $('#tags').dropdown({
                values: @json($tags),
                placeholder: '请选择标签',
            });

            $('.ui.checkbox').checkbox();
            $('.tabular.menu .item').tab();

            // $(document).on('load', '.tabular.menu .item', function (event) {
            //     console.log(event.type);
            // });

            // text 自动拉伸
            OP.editorResize('text');

            var submitted = false,
                changed = false;

            var form = $('form').submit(function () {
                submitted = true;
            });

            $(':input', form).bind('input change', function (e) {
                var tagName = $(this).prop('tagName');

                if (tagName.match(/(input|textarea)/i) && e.type == 'change') {
                    return;
                }

                changed = true;
            });

            form.bind('field', function () {
                changed = true;
            });

            // 自动检测离开页
            $(window).bind('beforeunload', function () {
                if (changed && !submitted) {
                    return '内容已经改变尚未保存, 您确认要离开此页面吗?';
                }
            });

            var textarea = $('#text'),
                isFullScreen = false,
                toolbar = $('<div class="editor" id="wmd-button-bar" />').insertBefore(textarea.parent()),
                preview = $('<div id="wmd-preview" class="wmd-hidetab" />').insertAfter('.editor');

            var options = {};

            options.strings = {
                bold: '加粗 <strong> Ctrl+B',
                boldexample: '加粗文字',

                italic: '斜体 <em> Ctrl+I',
                italicexample: '斜体文字',

                link: '链接 <a> Ctrl+L',
                linkdescription: '请输入链接描述',

                quote:  '引用 <blockquote> Ctrl+Q',
                quoteexample: '引用文字',

                code: '代码 <pre><code> Ctrl+K',
                codeexample: '请输入代码',

                image: '图片 <img> Ctrl+G',
                imagedescription: '请输入图片描述',

                olist: '数字列表 <ol> Ctrl+O',
                ulist: '普通列表 <ul> Ctrl+U',
                litem: '列表项目',

                heading: '标题 <h1>/<h2> Ctrl+H',
                headingexample: '标题文字',

                hr: '分割线 <hr> Ctrl+R',
                more: '摘要分割线 <!--more--> Ctrl+M',

                undo: '撤销 - Ctrl+Z',
                redo: '重做 - Ctrl+Y',
                redomac: '重做 - Ctrl+Shift+Z',

                fullscreen: '全屏 - Ctrl+J',
                exitFullscreen: '退出全屏 - Ctrl+E',
                fullscreenUnsupport: '此浏览器不支持全屏操作',

                // <div class="ui tabular menu">
                // <a class="item active" data-tab="first">First</a>
                // <a class="item" data-tab="second">Second</a>
                // <a class="item" data-tab="third">Third</a>
                // </div>
                // <div class="ui tab active" data-tab="first">First </div>
                // <div class="ui tab" data-tab="second">Second </div>
                // <div class="ui tab" data-tab="third">Third </div>

                imagedialog: '<div class="ui header">插入图片</div><div class="ui tabular menu"><a class="active item" data-tab="local">本地上传</a><a class="item" data-tab="remote">远程地址获取</a></div>',
                imageLocalUploadUrl: '{{ route('upload', ['cid' => $post->id]) }}',
                linkdialog: '<div class="ui header">插入链接</div><p>请在下方的输入框内输入要插入的链接地址</p>',

                ok: '确定',
                cancel: '取消',

                help: 'Markdown语法帮助'
            };

            var converter = new HyperDown(),
                editor = new Markdown.Editor(converter, '', options);

            // 自动跟随
            converter.enableHtml(true);
            converter.enableLine(true);
            var reloadScroll = scrollableEditor(textarea, preview);

            // 修正白名单
            converter.hook('makeHtml', function (html) {
                html = html.replace('<p><!--more--></p>', '<!--more-->');

                if (html.indexOf('<!--more-->') > 0) {
                    var parts = html.split(/\s*<\!\-\-more\-\->\s*/),
                        summary = parts.shift(),
                        details = parts.join('');

                    html = '<div class="summary">' + summary + '</div>'
                        + '<div class="details">' + details + '</div>';
                }

                // 替换block
                html = html.replace(/<(iframe|embed)\s+([^>]*)>/ig, function (all, tag, src) {
                    if (src[src.length - 1] == '/') {
                        src = src.substring(0, src.length - 1);
                    }

                    return '<div style="border: 1px solid #ccc; height: 40px; overflow: hidden; line-height: 40px; text-align: center; font-size: 12px; color: #777"><strong>'
                        + tag + '</strong> : ' + $.trim(src) + '</div>';
                });

                return html;
            });

            editor.hooks.chain('onPreviewRefresh', function () {
                var images = $('img', preview), count = images.length;

                if (count == 0) {
                    reloadScroll(true);
                } else {
                    images.load(function () {
                        count --;

                        if (count == 0) {
                            reloadScroll(true);
                        }
                    });
                }
            });

            var th = textarea.height(), ph = preview.height();
                // uploadBtn = $('<button type="button" id="btn-fullscreen-upload" class="btn btn-link">'
                //     + '<i class="i-upload">附件</i></button>')
                //     .prependTo('.submit .right')
                //     .click(function() {
                //         $('a', $('.typecho-option-tabs li').not('.active')).trigger('click');
                //         return false;
                //     });

            $('.typecho-option-tabs li').click(function () {
                uploadBtn.find('i').toggleClass('i-upload-active',
                    $('#tab-files-btn', this).length > 0);
            });

            editor.hooks.chain('enterFakeFullScreen', function () {
                th = textarea.height();
                ph = preview.height();
                $(document.body).addClass('fullscreen');
                var h = $(window).height() - toolbar.outerHeight();

                textarea.css('height', h);
                preview.css('height', h);

                $('#content').removeClass('ui main stackable grid container');
                $('#post-area-container').removeClass('ui container');
                $('form').removeClass('ui form');
                $('#post-area-grid').removeClass('ui two column stackable grid');
                $('#post-area-left').removeClass('twelve wide column');
                $('#post-area-right').removeClass('four wide column');

                isFullScreen = true;
            });

            editor.hooks.chain('enterFullScreen', function () {
                $(document.body).addClass('fullscreen');

                var h = window.screen.height - toolbar.outerHeight();
                textarea.css('height', h);
                preview.css('height', h);

                isFullScreen = true;
            });

            editor.hooks.chain('exitFullScreen', function () {
                $(document.body).removeClass('fullscreen');
                textarea.height(th);
                preview.height(ph);

                $('#content').addClass('ui main stackable grid container');
                $('#post-area-container').addClass('ui container');
                $('form').addClass('ui form');
                $('#post-area-grid').addClass('ui two column stackable grid');
                $('#post-area-left').addClass('twelve wide column');
                $('#post-area-right').addClass('four wide column');

                isFullScreen = false;
            });

            editor.hooks.chain('commandExecuted', function () {
                textarea.trigger('input');
            });

            function initMarkdown() {
                editor.run();

                // 编辑预览切换
                var edittab = $('.editor').prepend('<div class="wmd-edittab"><a href="#wmd-editarea" class="active">撰写</a><a href="#wmd-preview">预览</a></div>'),
                    editarea = $(textarea.parent()).attr("id", "wmd-editarea");

                $(".wmd-edittab a").click(function() {
                    $(".wmd-edittab a").removeClass('active');
                    $(this).addClass("active");
                    $("#wmd-editarea, #wmd-preview").addClass("wmd-hidetab");

                    var selected_tab = $(this).attr("href"),
                        selected_el = $(selected_tab).removeClass("wmd-hidetab");

                    // 预览时隐藏编辑器按钮
                    if (selected_tab == "#wmd-preview") {
                        $("#wmd-button-row").addClass("wmd-visualhide");
                    } else {
                        $("#wmd-button-row").removeClass("wmd-visualhide");
                    }

                    // 预览和编辑窗口高度一致
                    $("#wmd-preview").outerHeight($("#wmd-editarea").innerHeight());

                    return false;
                });
            }

            initMarkdown();

        });

    </script>
@endsection