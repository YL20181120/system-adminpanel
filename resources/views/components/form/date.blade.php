@props([
    'label',
    'valiName' => '',
    'placeholder' => '',
    'name' => '',
    'value' => '',
    'required' => false,
    'help' => '',
    'onblur' => 'void(0)',
    'disabled' => false,
    'pattern' => '',
    'range' => false
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <input type="text" name="{{ $name }}" value='{{ $value }}'
               @required($required)
               vali-name="{{ $valiName ?? $label }}"
               placeholder="{{ $placeholder }}"
               @disabled($disabled)
               pattern="{{ $pattern }}"
               onblur="{{ $onblur }}"
            {{ $range ? 'data-date-range' : 'data-date-input' }}
            @class(['layui-input','layui-bg-gray' => $disabled])
        >
        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
