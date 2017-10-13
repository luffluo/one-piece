@if (count(sidebar_block()) > 0)
    <div id="secondary" class="col-md-3 col-md-offset-1" role="complementary">
        @if (sidebar_block_open('show_recent_posts'))
            <section class="widget">
                <h3 class="widget-title">最新文章</h3>
                <ul class="widget-list">
                    @foreach ($sidebarRecentPosts as $sidebarRecentPost)
                        <li><a href="{{ route('post.show', $sidebarRecentPost->id) }}">{{ $sidebarRecentPost->headline(30) }}</a></li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (sidebar_block_open('show_recent_comments'))
            <section class="widget">
                <h3 class="widget-title">最近回复</h3>
                <ul class="widget-list">
                    @foreach ($sidebarRecentComments as $sidebarRecentComment)
                        <li><span>{{ $sidebarRecentComment->user->displayName() }}: </span>{{ $sidebarRecentComment->text }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (sidebar_block_open('show_tag'))
            <section class="widget">
                <h3 class="widget-title">标签</h3>
                <ol class="widget-list">
                    @foreach ($sidebarTags as $sidebarTag)
                        <li><a href="{{ route('tag.posts', $sidebarTag->slug) }}">{{ $sidebarTag->name }} ({{ $sidebarTag->count }})</a></li>
                    @endforeach
                </ol>
            </section>
        @endif

        @if (sidebar_block_open('show_archive'))
            <section class="widget">
                <h3 class="widget-title">归档</h3>
                <ol class="widget-list">
                    @foreach ($sidebarArchives as $sidebarArchive)
                        <li><a href="{{ route('archive', ['year' => $sidebarArchive['year'], 'month' => $sidebarArchive['month']]) }}">{{ $sidebarArchive['date'] }}</a></li>
                    @endforeach
                </ol>
            </section>
        @endif

        @if (sidebar_block_open('show_other'))
            <section class="widget">
                <h3 class="widget-title">其它</h3>
                <ol class="widget-list">
                    @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    @endguest

                    @auth
                    <li><a href="{{ route('logout') }}">退出</a></li>
                    @endauth

                    <li><a href="{{ route('feed') }}">文章 RSS</a></li>
                </ol>
            </section>
        @endif
    </div>
@endif
