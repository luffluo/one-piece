@if (in_array('ShowRecentPosts', $sidebarBlock))
<section class="sidebar-module">
    <h4>最新文章</h4>
    <ol class="list-unstyled">
        @foreach ($sidebarRecentPosts as $sidebarRecentPost)
            <li><a href="{{ route('post.show', $sidebarRecentPost->id) }}">{{ $sidebarRecentPost->getTitle() }}</a></li>
        @endforeach
    </ol>
</section>
@endif

@if (in_array('ShowTag', $sidebarBlock))
<section class="sidebar-module">
    <h4>标签</h4>
    <ol class="list-unstyled">
        @foreach ($sidebarTags as $sidebarTag)
            <li><a href="{{ route('tags') . '#' . $sidebarTag->slug }}">{{ $sidebarTag->name }} <span class="badge">{{ $sidebarTag->count }}</span></a></li>
        @endforeach
    </ol>
</section>
@endif

@if (in_array('ShowArchive', $sidebarBlock))
<section class="sidebar-module">
    <h4>归档</h4>
    <ol class="list-unstyled">
        @foreach ($sidebarArchives as $sidebarArchive)
        <li><a href="{{ route('archive', ['year' => $sidebarArchive['year'], 'month' => $sidebarArchive['month']]) }}">{{ $sidebarArchive['date'] }}</a></li>
        @endforeach
    </ol>
</section>
@endif

@if (in_array('ShowOther', $sidebarBlock))
    <section class="sidebar-module">
        <h4>其它</h4>
        <ol class="list-unstyled">
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