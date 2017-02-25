@extends('admin::layout')
@section('title')区域列表 - 区域管理@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户管理</li>
            <li>修改信息</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20">
                            <i>添加学校</i>
                        </div>
                        <div>
                            <form action="{{ url('admin/user/store/') }}" autocomplete="off"
                                  class="form-horizontal col-md-12" method="post">
                                {{ csrf_field() }}
                                <div class="form-group form-group-sm">
                                    <input type="hidden" id="id" name="id" value="{{$lists['id']}}">
                                    <label class="col-md-4 control-label">用户姓名</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="real_name" id="real_name"
                                               value="{{$lists['real_name']}}">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户昵称</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="nick_name" id="nick_name"
                                               value="{{$lists['nick_name'] or '暂无'}}">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户性别</label>
                                    <div class="col-md-4">
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['sex']==0) checked @endif name="sex" id="sex"
                                                   value="0">保密
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['sex']==1) checked @endif name="sex" id="sex"
                                                   value="1">男
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['sex']==2) checked @endif name="sex" id="sex"
                                                   value="2">女
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户手机号</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="phone" id="phone"
                                               value="{{$lists['phone']}}">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">省份</label>
                                    <div class="col-md-4">
                                        <select name="province_id" type="1" id="province_id" class="form-control">
                                            <option value="{{$lists['school']['province_id']}}">{{$lists['school']['province']}}</option>
                                            <option value="">请选择省</option>
                                            @foreach($province_id as $pro)
                                                <option value="{{$pro['id']}}">{{$pro['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">市</label>
                                    <div class="col-md-4">
                                        <select name="city_id" type="2" id="city_id" class="form-control">
                                            <option value="{{$lists['school']['city_id']}}">{{$lists['school']['city']}}</option>
                                            <option value=''>请选择市</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">区/县</label>
                                    <div class="col-md-4">
                                        <select name="district_id" id="district_id" class="form-control">
                                            <option value="{{$lists['school']['district_id']}}">{{$lists['school']['district']}}</option>
                                            <option value=''>请选择区/县</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">学校名称</label>
                                    <div class="col-md-4">

                                        <select name="school" id="school" class="form-control">
                                            <option value="{{$lists['school']['id']}}">{{$lists['school']['name']}}</option>
                                            <option value=''>请选择学校</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户地址</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="address" id="address"
                                               value="{{$lists['address']}}">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户金额</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="money" id="money"
                                               value="{{$lists['money']}}">
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">用户状态</label>
                                    <div class="col-md-4">
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['is_banned']=='yes') checked
                                                   @endif name="is_banned" id="is_banned" value="yes">禁用
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['is_banned']=='no') checked
                                                   @endif name="is_banned" id="is_banned" value="no">未禁用
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">审核状态</label>
                                    <div class="col-md-4">
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['status']=='normal') checked
                                                   @endif name="status" id="status" value="normal">通过
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" @if($lists['status']=='review') checked
                                                   @endif name="status" id="status" value="review">未通过
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

