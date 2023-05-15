@props([
    'type' => 'primary',
])
@if(\Admin\Admin::check_admin_permission(auth('admin')->user(), $attributes))
    <button {{ $attributes->merge(['class' => 'layui-btn layui-btn-sm layui-btn-' . $type]) }}>{{ $slot->isEmpty() ? 'Button' : $slot }}</button>
@endif
