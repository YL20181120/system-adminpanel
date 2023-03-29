@props([
    'name' => 'name',
    'label' => 'Label',
    'placeholder' => 'Placeholder',
])
<div class="layui-form-item layui-inline">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-inline">
        <input name="_search[{{ $name }}]" value="{{ request()->get("_search[$name]", '') }}"
               placeholder="{{ $placeholder }}"
               class="layui-input">
    </div>
</div>
