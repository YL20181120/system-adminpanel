@props([
    'label',
    'value' => '',
    'height' => '',
    'help' => '',
    'placeholder' => '',
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <textarea name="content" style="height: {{ $height }}px"
                  placeholder="{{ $placeholder }}" class="layui-textarea">{{ $value }}</textarea>
        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
