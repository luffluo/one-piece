<nav class="ui stackable mini borderless menu">
    <div class="ui container">
        <div class="header item">
            <a title="{{ option('description') }}" href="{{ route('home') }}" class="navbar-brand">
                <h2>{{ option('title', config('app.name')) }}</h2>
            </a>
        </div>

        @foreach($navigations as $navigation)
            <a class="ui medium header {{ request()->fullUrlIs($navigation->text . '*') ? 'active ' : '' }}item" href="{{ url($navigation->text) }}" title="{{ $navigation->title }}">
                @if ($navigation->slug)<i class="{{ $navigation->slug }} icon"> </i>@endif{{ $navigation->title }}</a>
        @endforeach

        <div class="right menu">
            <div class="item">
                <form role="search" method="get" action="{{ route('search') }}">
                    <div class="ui icon input">
                        <input type="text" name="q" value="{{ isset($search) && ! empty($search) ? $search : '' }}" placeholder="输入关键字搜索">
                        <i class="search icon"></i>
                    </div>
                </form>
            </div>

            @guest
                <a class="ui medium header item" href="{{ route('login') }}" role="button" aria-haspopup="true" aria-expanded="false">登录</a>
                @if(option('allow_register'))
                    <a class="ui medium header item" href="{{ route('register') }}" role="button" aria-haspopup="true" aria-expanded="false">注册</a>
                @endif
            @else
                <div class="ui simple dropdown medium header item">
                    <div class="text">
                        <img class="ui avatar image" src="{{ auth()->user()->showAvatar() }}">
                        {{ auth()->user()->showName() }}
                    </div>
                    <i class="dropdown icon"></i>

                    <div class="ui stackable transition menu">
                        <a class="item" href="{{ route('users.center', auth()->user()->name) }}">
                            <i class="user icon"></i>
                            个人中心
                        </a>

                        <a class="item" href="{{ route('users.edit_profile', auth()->user()->name) }}">
                            <i class="setting icon"></i>
                            账号设置
                        </a>

                        @if (Gate::allows('enter-admin-dashboard'))
                            <a class="item" href="{{ route('admin.home') }}">
                                <i class="tachometer alternate icon"></i>
                                进入后台
                            </a>
                        @endif

                        <div class="ui divider"></div>

                        <a class="item" href="{{ route('logout') }}" data-method="post" data-confirm="确定要退出吗？">
                            <i class="sign out alternate icon"></i>
                            退出
                        </a>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>