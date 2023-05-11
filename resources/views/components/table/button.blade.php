@props([
    'type' => 'primary',
])
@if(\System\System::check_system_permission(auth('system')->user(), $attributes))
    <button {{ $attributes->merge(['class' => 'layui-btn layui-btn-sm layui-btn-' . $type]) }}>{{ $slot->isEmpty() ? 'Button' : $slot }}</button>
@endif
