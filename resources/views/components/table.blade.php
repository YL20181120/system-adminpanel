@props([
    'title'  => '',
])
<div class="layui-card">
    {{ $style ?? '' }}
    @if (!blank($title))
        <div class="layui-card-header" style="position:static !important;">
            <span class="layui-icon font-s10 color-desc margin-right-5">&#xe65b;</span>{{ $title ?? '' }}
            <div class="pull-right">
                {{ $button ?? '' }}
            </div>
        </div>
    @endif
    <div class="layui-card-line"></div>
    <div class="layui-card-body">
        <div class="layui-card-table">
            {{ $slot }}
        </div>
    </div>
    {{ $script ?? '' }}
</div>
