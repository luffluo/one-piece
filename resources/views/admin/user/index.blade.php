@extends('admin::layout')
@section('title')区域列表 - 区域管理@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户管理</li>
            <li>用户首页</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20" style="float: left;">
                            <div style="float: left;">
                                <i>用户管理</i>
                            </div>
                            <div style="float: left;padding-left: 100px;">
                                <form class="form-inline" action="{{ url('admin/user') }}" method="get">
                                    <select name="users_status">
                                        <option value="">全部用户</option>
                                        <option value="review">待审核用户--{{$review}}</option>
                                        <option value="normal">通过用户--{{$normal}}</option>
                                    </select>
                                    <select name="users_is_banned">
                                        <option value="">全部用户</option>
                                        <option value="yes">禁用用户--{{$yes}}</option>
                                        <option value="no">未禁用用户--{{$no}}</option>
                                    </select>
                                    <select name="schools_name">
                                        <option value="">全部学校</option>
                                        @foreach($school as $s)
                                            <option value="{{$s->name}}">{{$s->name}}--{{$s->num}}人</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="users_real_name" placeholder="请输入用户名"
                                           value="{{$name}}">
                                    <input type="text" name="users_phone" placeholder="请输入手机号"
                                           value="{{$phone}}">
                                    <button type="submit" class="btn btn-primary btn-xs">查询</button>
                                </form>
                            </div>
                            <div style="float: left;padding-left: 50px;">
                                <label>全部用户</label>
                                {{$alluser}}人
                            </div>
                            <div style="float: left;padding-left: 50px;">
                                <label>昨日新增用户</label>
                                {{$yesterday}}人
                            </div>
                            <div style="float: left;padding-left: 50px;">
                                <label>该学校用户</label>
                                {{$school_number}}人
                            </div>
                        </div>
                        @if(Session::has('message'))
                            <div class="alert alert-info"> {{Session::get('message')}}
                            </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">呢称</th>
                                <th class="col-md-1">姓名</th>
                                <th class="col-md-1">性别</th>
                                <th class="col-md-1">手机号</th>
                                <th class="col-md-1">学校</th>
                                <th class="col-md-1">地址</th>
                                <th class="col-md-1">金额</th>
                                <th class="col-md-1">是否猎人</th>
                                <th class="col-md-1">审核状态</th>
                                <th class="col-md-1">是否禁用</th>
                                <th class="col-md-1">操作</th>
                                <th class="col-md-1">编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            @inject('userPresenter', 'Notadd\Task\Presenters\UserPresenter')
                            @foreach($lists as $list)
                                <tr>
                                    <td>{{$list->id}}</td>
                                    <td>{{$list->nick_name or '暂无'}}</td>
                                    <td>{{$list->real_name}}</td>
                                    <td>{{ $userPresenter->sexName($list->sex) }}</td>
                                    <td>{{$list->phone}}</td>
                                    <td>{{$list->name}}</td>
                                    <td>{{$list->address or '暂无'}}</td>
                                    <td>{{$list->money}}</td>
                                    <td>{{ $userPresenter->is_hunterStatus($list->is_hunter) }}</td>
                                    <td>{{ $userPresenter->checkStatus($list->status) }}</td>
                                    <td>{{ $userPresenter->bannedStatus($list->is_banned) }}</td>
                                    <td>
                                        @if($list->status=='review')
                                            <form action="{{url('admin/check/'.$list['id'])}}" method="POST"
                                                  style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="status" value="normal">
                                                <button type="submit" class="btn btn-success btn-xs"
                                                        data-form-confirm="确定要通过该用户审核吗？">
                                                    通过
                                                </button>
                                            </form>
                                        @elseif( $list['is_banned'] == 'yes' )
                                            <form action="{{url('admin/status/'.$list['id'])}}" method="POST"
                                                  style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="is_banned" value="no">
                                                <button type="submit" class="btn btn-success btn-xs"
                                                        data-form-confirm="确定要解除该用户吗？">
                                                    解除
                                                </button>
                                            </form>

                                        @else
                                            <form action="{{url('admin/status/'.$list['id'])}}" method="POST"
                                                  style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="is_banned" value="yes">
                                                <button type="submit" class="btn btn-danger btn-xs"
                                                        data-form-confirm="确定要禁用该用户吗？">
                                                    禁用
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('admin/user/edit/'.$list['id'])}}"
                                           class="btn btn-success btn-xs">编辑 </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="panel-footer clearfix">
                            <nav class="right">{{ $lists->appends($map)->links() }}</nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection