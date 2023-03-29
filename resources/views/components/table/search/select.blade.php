@props([
    'name' => 'name',
    'label' => 'Label',
    'placeholder' => 'Placeholder',
    'options' => []
])
<div class="layui-form-item layui-inline">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-inline">
        <select class="layui-select" name="_search[{{ $name }}]">
            <option value=''>{{ $placeholder }}</option>
            @foreach($options as $k => $v)
                @if($k === \request()->get("_search[$name]", ""))
                    <option selected value="{{$k}}">{{$v}}</option>
                @else
                    <option value="{{$k}}">{{$v}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
