@props([
    'script' => '',
])
<div>
    <div class="layui-card-body">
        {{ $slot }}
    </div>
    {{ $script }}
</div>
