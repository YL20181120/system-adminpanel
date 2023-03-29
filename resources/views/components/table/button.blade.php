@props([
    'type' => 'primary',
    'auth' => '', // todo check auth
])

<button {{ $attributes->merge(['class' => 'layui-btn layui-btn-sm layui-btn-' . $type]) }}>{{ $slot->isEmpty() ? 'Button' : $slot }}</button>
