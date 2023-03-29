<x-system::table>
    <x-slot:title>任务管理</x-slot:title>

    <x-slot:button>
        <x-system::table.button data-table-id="TaskTable" data-modal="{{ route('system.tasks.create') }}"
                                data-width="600px">
            创建新任务
        </x-system::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        @include('system::task.index_search')
        <table id="TaskTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#TaskTable').layTable({
                    even: true, height: 'full', page: @js($page),
                    sort: {field: 'created_at', type: 'desc'},
                    cols: [[
                        // {checkbox: true, field: 'sps'},
                        {
                            field: 'id',
                            title: 'ID',
                            width: 80,
                            align: 'center',
                        },
                        {
                            field: 'user',
                            title: '用户',
                            minWidth: 120,
                            align: 'center',
                            templet: '<div>@{{d.user.username}}</div>'
                        },
                        {
                            field: 'type_label',
                            title: '任务类型',
                            // minWidth: 220,
                        },
                        {
                            field: 'status_label',
                            title: '状态',
                            minWidth: 120,
                            align: 'center',
                        },
                        {
                            field: 'start_at',
                            title: '开始时间',
                            minWidth: 120,
                            align: 'center',
                            sort: true
                        },
                        {
                            field: 'end_at',
                            title: '结束时间',
                            minWidth: 120,
                            align: 'center',
                            sort: true
                        },
                        {
                            field: 'remark',
                            title: '备注',
                            minWidth: 120,
                            align: 'center',
                        }, {
                            field: 'reason',
                            title: 'Worker say',
                            minWidth: 120,
                            align: 'center',
                        },
                        {toolbar: '#toolbar', title: '操作面板', minWidth: 150, align: 'center', fixed: 'right'},
                    ]]
                });

                // 数据状态切换操作
                layui.form.on('switch(whatsapp_checkedSwitch)', function (object) {
                    object.data = {status: object.elem.checked > 0 ? 1 : 0};
                    object.data.id = object.value.split('|')[object.data.status] || object.value;
                    $.form.load("{{ route('system.contact.state', 'whatsapp') }}", object.data, 'post', function (ret) {
                        if (ret.code < 1) $.msg.error(ret.info, 3, function () {
                            $('#TaskTable').trigger('reload');
                        }); else {
                            $('#TaskTable').trigger('reload');
                        }
                        return false;
                    }, false);
                });
            });
        </script>

        <script type="text/html" id="toolbar">
            @{{# if(d.status == 2) { }}
            <x-system::table.row-action
                href="{{ route('system.contact.export', '') }}/@{{ d.id }}"
                target="_blank"
                type="primary">下载结果
            </x-system::table.row-action>
            @{{# } }}
            <x-system::table.row-action data-confirm="确定要删除任务吗？"
                                        data-action="{{ route('system.tasks.destroy') }}"
                                        data-value="id#@{{d.id}};_method#delete"
                                        type="danger">删 除
            </x-system::table.row-action>
        </script>
    </x-slot:script>
</x-system::table>
