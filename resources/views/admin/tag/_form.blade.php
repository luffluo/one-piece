<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">标签名称 *</div>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" placeholder="请输入名称" value="{{ old('name', $tag->name) }}">
        <span class="help-block">这是标签在站点中显示的名称.可以使用中文,如 "地球".</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">标签缩略名</div>
    <div class="col-md-4">
        <input type="text" class="form-control" name="slug" placeholder="请输入标识" value="{{ old('slug', $tag->slug) }}">
        <span class="help-block">标签缩略名用于创建友好的链接形式, 如果留空则默认使用标签名称.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">描述</div>
    <div class="col-md-4">
        <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ old('description', $tag->description) }}</textarea>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">提交</button>
    </div>
</div>
