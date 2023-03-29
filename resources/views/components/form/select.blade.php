@props([
    'name' => 'name',
    'label' => 'Label',
    'placeholder' => 'Placeholder',
    'options' => [],
    'help' => '',
    'value' => ''
])
<div class="layui-form-item">
    <label class="layui-form-label label-required-next">{{ $label }}</label>
    <div class="layui-input-block">
        <select name='{{ $name }}' class='layui-select' lay-search data-value="{{ $value }}">
            @foreach($options as $k => $v)
                <option @selected($k == $value) value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
        <p class="help-block">{{ $help }}</p>
    </div>
</div>
