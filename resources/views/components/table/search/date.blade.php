@props([
    'name' => 'create_at',
    'label' => '创建时间',
    'placeholder' => '请选择创建时间',
    'range' => true
])
<div class="layui-form-item layui-inline">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-inline">
        <input {{ $range ? 'data-date-range' : 'data-date-input' }} name="_search[{{ $name }}]"
               value="{{ request()->get("_search[$name]", '') }}"
               placeholder="{{ $placeholder }}"
               class="layui-input">
    </div>
</div>
