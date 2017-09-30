<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fa fa-home"> </i> {{ option('title', 'Luff') }}
            </a>
        </div>

        <ul class="nav navbar-nav">

            @forelse($navigations as $navigation)
                @if (request()->fullUrlIs($navigation->text . '*'))
                    <li class="nav-item active">
                @else
                    <li class="nav-item">
                @endif
                    <a href="{{ url($navigation->text) }}" class="navigation-link" title="{{ $navigation->title }}">
                        @if ($navigation->slug)<i class="fa fa-{{ $navigation->slug }}"> </i>@endif{{ $navigation->title }}</a>
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