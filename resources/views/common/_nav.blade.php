<div class="luff-header">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{ route('home') }}" class="navbar-brand">
                {{ option('title', config('app.name')) }}
            </a>
        </div>

        <div id="app-navbar-collapse" class="collapse navbar-collapse">

            <ul class="nav navbar-nav">

                @foreach($navigations as $navigation)
                    @if (request()->fullUrlIs($navigation->text . '*'))
                        <li class="nav-item active">
                    @else
                        <li class="nav-item">
                    @endif
                            <a href="{{ url($navigation->text) }}" class="navigation-link" title="{{ $navigation->title }}">
                                @if ($navigation->slug)<i class="fa fa-{{ $navigation->slug }}"> </i>@endif{{ $navigation->title }}</a>
                        </li>
                @endforeach
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li>
                        <a href="{{ route('login') }}" role="button" aria-haspopup="true" aria-expanded="false">登录</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{ auth()->user()->showAvatar() }}" class="img-responsive" width="25px" height="25px" style="border-radius:3px;">
                            </span>
                            {{ auth()->user()->showName() }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users.center', auth()->user()->name) }}">个人中心</a></li>
                            <li><a href="{{ route('users.edit_profile', auth()->user()->name) }}">编辑信息</a></li>

                            @if (Gate::allows('enter-admin-dashboard'))
                                <li><a href="{{ route('admin.home') }}">进入后台</a></li>
                            @endif

                            <li role="separator" class="divider"></li>

                            <li>
                                <a href="{{ route('logout') }}" data-method="post" data-confirm="确定要退出吗？">退出</a>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>

            <form class="navbar-form navbar-right" role="search" method="get" action="{{ route('search') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" value="{{ isset($search) && ! empty($search) ? $search : '' }}" placeholder="输入关键字搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-search"> </i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</nav>
</div>