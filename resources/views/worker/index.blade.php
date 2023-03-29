<x-system::table>
    <x-slot:title>Worker</x-slot:title>
    <x-slot:button>
        <x-system::table.button data-table-id="WorkerTable" data-modal="{{ route('system.worker.create') }}"
                                data-width="600px">
            添加
        </x-system::table.button>

        <x-system::table.button data-table-id="WorkerTable" data-action="{{ route('system.worker.destroy') }}"
                                data-rule="id#{id};_method#delete"
                                data-confirm="确定要批量 Role 吗？"
                                type="danger">
            删除
        </x-system::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        @include('system::worker.index_search')
        <table id="WorkerTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#WorkerTable').layTable({
                    even: true, height: 'full',
                    cols: [[
                        {checkbox: true, fixed: true},
                        {
                            field: 'username', title: 'Username', align: 'center', minWidth: 140
                        }, {
                            field: 'description', title: 'Desc.', align: 'center', minWidth: 140
                        },
                        {
                            field: 'last_login_at', title: '上次登录时间', align: 'center', minWidth: 170, sort: true
                        },
                        {
                            field: 'last_login_ip', title: '上次登录IP', align: 'center', minWidth: 170, sort: true
                        },
                        {
                            field: 'created_at', title: '创建时间', align: 'center', minWidth: 170, sort: true
                        },
                        {
                            toolbar: '#ToolbarRoleTableTpl',
                            title: '操作面板',
                            align: 'center',
                            minWidth: 210,
                            fixed: 'right'
                        },
                    ]]
                });
            });
        </script>
        <!-- 数据操作工具条模板 -->
        <script type="text/html" id="ToolbarRoleTableTpl">
            <x-system::table.row-action data-event-dbclick data-width="600px" data-title="编辑 Worker"
                                        data-modal='/system/worker/@{{d.id}}'>编 辑
            </x-system::table.row-action>
            <x-system::table.row-action data-title="设置密码"
                                        data-modal="/system/worker/@{{d.id}}/password" type="normal">密
                码
            </x-system::table.row-action>
            <x-system::table.row-action data-confirm="确定要删除 Worker吗?"
                                        data-action="{{ route('system.worker.destroy') }}"
                                        data-value="id#@{{d.id}};_method#delete"
                                        type="danger">删 除
            </x-system::table.row-action>
        </script>
    </x-slot:script>
</x-system::table>
