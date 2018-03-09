@if (count(sidebar_block()) > 0)
    <div id="secondary" class="four wide right floated column" role="complementary">
        @if (sidebar_block_open('show_recent_posts'))
            <section class="widget">
                <h4 class="ui header">最新文章</h4>
                <div class="ui list">
                    @foreach ($sidebarRecentPosts as $sidebarRecentPost)
                        <a class="item" href="{{ route('posts.show', $sidebarRecentPost->id) }}">{{ $sidebarRecentPost->headline(45) }}</a>
                    @endforeach
                </div>
            </section>
            <div class="ui hidden divider"></div>
        @endif

        @if (sidebar_block_open('show_recent_comments'))
            <section class="widget">
                <h4 class="ui header">最近回复</h4>
                <div class="ui list">
                    @foreach ($sidebarRecentComments as $sidebarRecentComment)
                        <div class="item">
                            <a title="{{ $sidebarRecentComment->user->showName() }}" href="{{ route('users.center', $sidebarRecentComment->user->name) }}">
                                {{ $sidebarRecentComment->user->showName() }}:
                            </a>
                            {{ strip_tags($sidebarRecentComment->excerpt(45)) }}
                        </div>
                    @endforeach
                </div>
            </section>
            <div class="ui hidden divider"></div>
        @endif

        @if (sidebar_block_open('show_tag'))
            <section class="widget">
                <a href="{{ route('tags.index') }}">
                    <h4 class="ui header">
                        标签
                    </h4>
                </a>
                <div class="ui list">
                    @foreach ($sidebarTags as $sidebarTag)
                        <a class="item" href="{{ route('tags.posts', $sidebarTag->slug) }}">{{ $sidebarTag->name }} ({{ $sidebarTag->count }})</a>
                    @endforeach
                </div>
            </section>
            <div class="ui hidden divider"></div>
        @endif

        @if (sidebar_block_open('show_archive'))
            <section class="widget">
                <h4 class="ui header">归档</h4>
                <div class="ui list">
                    @foreach ($sidebarArchives as $sidebarArchive)
                        <a class="item" href="{{ route('archive', ['year' => $sidebarArchive['year'], 'month' => $sidebarArchive['month']]) }}">{{ $sidebarArchive['date'] }}</a>
                    @endforeach
                </div>
            </section>
            <div class="ui hidden divider"></div>
        @endif

        @if (sidebar_block_open('show_other'))
            <section class="widget">
                <h4 class="ui header">其它</h4>
                <div class="ui list">
                    @auth
                        <a class="item" href="{{ route('logout') }}" data-method="post" data-confirm="确定要退出吗？">退出</a>
                    @else
                        <a class="item" href="{{ route('login') }}">登录</a>
                    @endauth

                    <a class="item" href="{{ route('feed') }}">文章 RSS</a>
                </div>
            </section>
        @endif
    </div>
@endif
