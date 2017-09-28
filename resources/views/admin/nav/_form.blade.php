<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航名称 *</label>
        <input type="text" class="form-control" name="title" placeholder="请输入名称" value="{{ old('title', $nav->title) }}">
        {{--<span class="help-block">这是导航在站点中显示的名称.可以使用中文,如 "地球".</span>--}}
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航链接 *</label>
        <input type="text" class="form-control" name="text" placeholder="请输入链接" value="{{ old('text', $nav->text) }}">
        {{--<span class="help-block">导航链接用于创建友好的链接形式, 如果留空则默认使用导航名称.</span>--}}
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航图标</label>
        <input type="text" class="form-control" name="slug" placeholder="请输入标识" value="{{ old('slug', $nav->slug) }}">
        {{--<span class="help-block">导航图标用于创建友好的链接形式, 如果留空则默认使用导航名称.</span>--}}
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航顺序</label>
        <input type="number" class="form-control" name="order" placeholder="请输入顺序" value="{{ old('order', $nav->order) }}">
        {{--<span class="help-block">导航顺序用于创建友好的链接形式, 如果留空则默认使用导航名称.</span>--}}
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        @if ($nav->exists)
            <button type="submit" class="btn btn-primary btn-sm">编辑导航</button>
        @else
            <button type="submit" class="btn btn-primary btn-sm">增加导航</button>
        @endif
    </div>
</div>
