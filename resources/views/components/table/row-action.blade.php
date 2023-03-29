@props([
    'type' => 'primary',
    'auth' => '', // todo check auth
])
<a {{ $attributes->merge(['class' => 'layui-btn layui-btn-sm layui-btn-' . $type]) }}>{{ $slot->isEmpty() ? 'Button' : $slot }}</a>
