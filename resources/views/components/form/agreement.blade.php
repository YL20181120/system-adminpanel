@props([
    'label',
    'name',
    'value' => false,
    'required' => false,
    'tips' => 'Yes'
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <label class="think-checkbox">
            <input type="checkbox" @checked($value === true) name="{{ $name }}" value="0"
                   lay-ignore>{{ $tips }}
        </label>
    </div>
</div>
