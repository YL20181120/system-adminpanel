@props([
    "id" => 'SortInputRoleTableTpl',
    'min' => 0,
    'dataBlurNumber' => 0,
    'dataActionBlur' => request()->url(),
    'field' => 'sort',  // 排序的字段名
])

<!-- 列表排序权重模板 -->
<script type="text/html" id="{{ $id }}">
    <input type="number" min="{{ $min }}" data-blur-number="{{ $dataBlurNumber }}"
           data-action-blur="{{ $dataActionBlur }}"
           data-value="id#{%d.id%};action#sort;{{ $field }}#{value};field#{{ $field }}" data-loading="false"
           value="<?php echo sprintf("{{d.%s}}", $field);?>"
           class="layui-input text-center"/>
</script>
