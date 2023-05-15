@props([
    'label',
    'name',
    'value' => '',
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <input type="checkbox" @checked($value) name="{{ $name }}" lay-skin="switch" title="ON|OFF">
    </div>
</div>
