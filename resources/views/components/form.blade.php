@props([
    'action' => request()->url(),
    'tableId' => '',
    'script' => '',
    'showCancel' => true,
    'cancelText' => __('admin::form.cancel'),
    'confirmText' => __('admin::form.saveData'),
])
<div>
    <form action="{{ $action }}" method="post" data-auto="true" class="layui-form layui-card"
          data-table-id="{{ $tableId }}" {{ $attributes->except('action', 'class', 'tableId') }}>

        <div class="layui-card-body" style="padding-left: 20px">
            {{ $slot }}
        </div>

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
