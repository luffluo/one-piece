@if (isset($sidebarBlock) && count($sidebarBlock) > 0)
    <div id="secondary" class="col-md-3 col-md-offset-1" role="complementary">
        @if (in_array('ShowRecentPosts', $sidebarBlock))
            <section class="widget">
                <h3 class="widget-title">最新文章</h3>
                <ul class="widget-list">
                    @foreach ($sidebarRecentPosts as $sidebarRecentPost)
                        <li><a href="{{ route('post.show', $sidebarRecentPost->id) }}">{{ $sidebarRecentPost->getTitle() }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (in_array('ShowTag', $sidebarBlock))
            <section class="widget">
                <h3 class="widget-title">标签</h3>
                <ol class="widget-list">
                    @foreach ($sidebarTags as $sidebarTag)
                        <li><a href="{{ route('tags') . '#' . $sidebarTag->slug }}">{{ $sidebarTag->name }}</a></li>
                    @endforeach
                </ol>
            </section>
        @endif

        @if (in_array('ShowArchive', $sidebarBlock))
            <section class="widget">
                <h3 class="widget-title">归档</h3>
                <ol class="widget-list">
                    @foreach ($sidebarArchives as $sidebarArchive)
                        <li><a href="{{ route('archive', ['year' => $sidebarArchive['year'], 'month' => $sidebarArchive['month']]) }}">{{ $sidebarArchive['date'] }}</a></li>
                    @endforeach
                </ol>
            </section>
        @endif

        @if (in_array('ShowOther', $sidebarBlock))
            <section class="widget">
                <h3 class="widget-title">其它</h3>
                <ol class="widget-list">
                    @guest
                    <li><a href="{{ route('admin.login') }}">登录</a></li>
                    @endguest

                    @auth
                    <li><a href="{{ route('admin.home') }}">进入后台</a></li>
                    <li><a href="{{ route('admin.logout') }}">退出</a></li>
                    @endauth

                    <li><a href="{{ route('feed.xml') }}">文章 RSS</a></li>
                </ol>
            </section>
        @endif
    </div>
@endif
