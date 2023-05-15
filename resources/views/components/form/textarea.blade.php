@props([
    'label',
    'value' => '',
    'help' => '',
    'placeholder' => '',
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <textarea name="content"
                  placeholder="{{ $placeholder }}" class="layui-textarea">{{ $value }}</textarea>
        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
