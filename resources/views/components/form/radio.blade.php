@props([
    'label',
    'name',
    'value' => '',
    'options' => []
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        @foreach($options as $k => $v)
        <input type="radio" name="{{ $name }}" value="{{ $k }}" title="{{ $v }}" @checked($k == $value)>
        @endforeach
    </div>
</div>
