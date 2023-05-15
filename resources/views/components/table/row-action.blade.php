@props([
    'type' => 'primary',
    'auth' => '', // todo check auth
])
@if(\Admin\Admin::check_admin_permission(auth()->user(), $attributes))
    <a {{ $attributes->merge(['class' => 'layui-btn layui-btn-sm layui-btn-' . $type]) }}>{{ $slot->isEmpty() ? 'Button' : $slot }}</a>
@endif
