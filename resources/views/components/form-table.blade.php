@props([
    'action' => request()->url(),
    'tableId' => '',
    'callback' => '',
    'script' => '',
    'showCancel' => true,
    'cancelText' => '取消编辑',
    'confirmText' => '保存数据'
])
<div>
    <form action="{{ $action }}" method="post" data-auto="true" class="layui-form layui-card"
          @if (!blank($callback))
          data-callback="{{ $callback }}"
          @endif
          data-table-id="{{ $tableId }}">

        {{ $slot }}

        <div class="hr-line-dashed"></div>

        <div class="layui-form-item text-center">
            <button class="layui-btn" type='submit'>{{ $confirmText }}</button>
            @if ($showCancel)
                <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>
                    {{ $cancelText }}
                </button>
            @endif
        </div>
    </form>

    {{ $script }}
</div>
