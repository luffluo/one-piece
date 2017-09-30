<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fa fa-home"> </i> {{ option('title', 'Luff') }}
            </a>
        </div>

        <ul class="nav navbar-nav">

            @forelse($navs as $nav)
                @if (request()->fullUrlIs($nav->text . '*'))
                    <li class="nav-item active">
                @else
                    <li class="nav-item">
                @endif
                    <a href="{{ url($nav->text) }}" class="nav-link" title="{{ $nav->title }}">
                        @if ($nav->slug)<i class="fa fa-{{ $nav->slug }}"> </i>@endif{{ $nav->title }}</a>
                </li>
            @empty
            @endforelse
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