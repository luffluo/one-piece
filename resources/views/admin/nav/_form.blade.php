<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航名称 *</label>
        <input type="text" class="form-control" name="title" placeholder="请输入名称" value="{{ old('title', $nav->title) }}">
        <span class="help-block">这是导航在站点中显示的名称.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航链接 *</label>
        <input type="text" class="form-control" name="text" placeholder="请输入链接" value="{{ old('text', $nav->text) }}">
        <span class="help-block">导航链接用于点击导航后显示的页面.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航图标</label>
        <input type="text" class="form-control" name="slug" placeholder="请输入标识" value="{{ old('slug', $nav->slug) }}">
        <span class="help-block">导航图标用于给导航添加一个 <code>Font Awesome</code> 的字体图标.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>导航顺序</label>
        <input type="number" class="form-control" name="order" placeholder="请输入顺序" value="{{ old('order', $nav->order) }}">
        <span class="help-block">导航顺序用于站点导航的显示顺序.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>状态</label>
        <select name="status" id="status">
            @foreach(['publish' => '显示', 'hidden' => '隐藏'] as $skey => $sval)
                @if($nav->status == $skey)
                    <option value="{{ $skey }}" selected="selected">{{ $sval }}</option>
                @else
                    <option value="{{ $skey }}">{{ $sval }}</option>
                @endif
            @endforeach
        </select>
        <span class="help-block">状态用于导航是否在站点显示.</span>
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
