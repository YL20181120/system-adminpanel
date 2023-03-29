@props([
    'label',
    'valiName' => '',
    'placeholder' => '',
    'name' => '',
    'value' => '',
    'type' => 'text',
    'required' => false,
    'help' => '',
    'disabled' => false,
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <label class="relative block label-required-null">
            <input type="{{ $type }}" name="{{ $name }}" value='{{ $value }}'
                   @required($required)
                   vali-name="{{ $valiName ?? $label }}"
                   placeholder="{{ $placeholder }}"
                   @disabled($disabled)
                   pattern="url"
                @class(['layui-input','layui-bg-gray' => $disabled])
            >
            <input type="hidden" name="{{ $name }}_ids">
            <a class="input-right-icon layui-icon layui-icon-upload-drag" data-file="btn" data-type="xls,xlsx"
               data-field="{{ $name }}"></a>
        </label>

        <p class="help-block">
            {{ $help }}
        </p>
    </div>
</div>
