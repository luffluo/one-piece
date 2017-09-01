@extends('admin::layouts.auth')
@section('title')登录到{{ option('site.company', 'Luff')  }}@endsection
@section('content')
<div class="page page-auth clearfix">
    <div class="auth-container">
        <div class="auth-container-wrap">
            <h1 class="site-logo h2 mb15"><a href="{{ url('/') }}"><span>{{ option('site.company', 'Luff')  }}</span></a></h1>
            {{--<h3 class="text-normal h4 text-center">Luff</h3>--}}
            <div class="form-container">
                <form action="{{ route('admin.login') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        <label alt="请输入账户" placeholder="账号"></label>
                    </div>
                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password" required>
                        <label alt="请输入密码" placeholder="密码"></label>
                    </div>

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p><strong>{{ $error }}</strong></p>
                            </div>
                        @endforeach
                    @endif
                    <div class="clearfix text-center">
                        <button type="submit" class="btn btn-lg btn-primary">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
    <script>
        $(function () {
            // 聚焦
            $('#name').select();
        })
    </script>
@endsection