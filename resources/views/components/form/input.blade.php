@props([
    'label',
    'valiName' => '',
    'placeholder' => '',
    'name' => '',
    'value' => '',
    'type' => 'text',
    'required' => false,
    'help' => '',
    'onblur' => 'void(0)',
    'disabled' => false,
    'pattern' => '',
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <input type="{{ $type }}" name="{{ $name }}" value='{{ $value }}'
               @required($required)
               vali-name="{{ $valiName ?? $label }}"
               placeholder="{{ $placeholder }}"
               @disabled($disabled)
               {{ $pattern }}
               onblur="{{ $onblur }}"
            @class(['layui-input','layui-bg-gray' => $disabled])
        >
        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
