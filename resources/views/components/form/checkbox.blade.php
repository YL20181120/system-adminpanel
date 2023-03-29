@props([
    'label',
    'name',
    'value' => [],
    'options' => []
])
<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <div class="layui-textarea help-checks">
            @foreach($options as $k => $v)
                <label class="think-checkbox">
                    <input type="checkbox" @checked(in_array($k, $value)) name="{{ $name }}[]" value="{{ $k }}"
                           lay-ignore>{{ $v }}
                </label>
            @endforeach
        </div>
    </div>
</div>
