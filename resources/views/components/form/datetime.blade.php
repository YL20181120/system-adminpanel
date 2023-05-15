@props([
'id' => '',
'label' => '',
'placeholder' => '',
'name' => '',
'value' => '',
'required' => false,
'help' => '',
'onblur' => 'void(0)',
'disabled' => false,
'pattern' => ''
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <input type="text"
               @required($required)
               vali-name="{{ $valiName ?? $label }}"
               placeholder="{{ $placeholder }}"
               @disabled($disabled)
               {{ $pattern }}
               onblur="{{ $onblur }}"
               name="{{ $name }}" value='{{ $value }}'
               @class(['layui-input','layui-bg-gray' => $disabled])
               id="{{ $id }}">
        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
