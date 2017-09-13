<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">
                <span class="fa fa-home"></span>
                Luff
            </a>
        </div>

        <ul class="nav navbar-nav">

            @if (request()->is('tags'))
                <li class="nav-item active">
                    <a href="{{ route('tags') }}" class="nav-link">
                        <span class="fa fa-tags"></span>&nbsp;
                        标签
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('tags') }}" class="nav-link">
                        <span class="fa fa-tags"></span>&nbsp;
                        标签
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a target="_blank" href="{{ route('feed') }}" class="nav-link">
                    <i class="fa fa-rss" aria-hidden="true"></i>
                    RSS
                </a>
            </li>
        </ul>

        <form class="navbar-form navbar-right" role="search" method="get" action="{{ route('search') }}">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="{{ isset($search) && ! empty($search) ? $search : '' }}" placeholder="输入关键字搜索">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">搜索</button>
                </span>
            </div>
        </form>
    </div>
</nav>