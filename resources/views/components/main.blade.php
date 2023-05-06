@props([
    'title'  => '',
    'style'  => '',
    'header' => '',
    'script' => '',
    'button' => '',
])
<div class="layui-card">
    {{ $style }}
    @if (!blank($title))
        <div class="layui-card-header">
            <span class="layui-icon font-s10 color-desc margin-right-5">&#xe65b;</span>{{ $title ?? '' }}
            <div class="pull-right">
                {{ $button }}
            </div>
        </div>
    @endif

    <div class="layui-card-line"></div>
    <div class="layui-card-body">
        <div class="layui-card-html">
            {{ $slot }}
        </div>
    </div>

</div>
