@props([
    'fieldset' => true,
    'action' => request()->url()
])
@if ($fieldset)
    <fieldset>
        <legend>条件搜索</legend>
        @endif

        <form class="layui-form layui-form-pane form-search" action="{{ $action }}" onsubmit="return false" method="get"
              autocomplete="off">
            {{ $slot }}
            <div class="layui-form-item layui-inline">
                <button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button>
            </div>
        </form>
        @if ($fieldset)
    </fieldset>
@endif
