<x-admin::table>
    <x-slot:title>Permission</x-slot:title>
    <x-slot:button>
        <x-admin::table.button data-table-id="permission" data-modal="{{ route('admin.permission.create') }}"
                                data-width="600px">
            添加
        </x-admin::table.button>

        <x-admin::table.button data-table-id="permission" data-action="{{ route('admin.permission.destroy') }}"
                                data-rule="id#{id};_method#delete"
                                data-confirm="确定要批量 Role 吗？"
                                type="danger">
            删除
        </x-admin::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        @include('admin::permission.index_search')
        <table id="permission" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#permission').layTable({
                    even: true, height: 'full',
                    cols: [[
                        {checkbox: true, fixed: true},
                        {
                            field: 'guard_name', title: 'Guard', align: 'center', minWidth: 140
                        }, {
                            field: 'name', title: 'Permission', align: 'center', minWidth: 140
                        },
                        {
                            field: 'created_at', title: '创建时间', align: 'center', minWidth: 170, sort: true
                        }, {
                            field: 'updated_at', title: '更新时间', align: 'center', minWidth: 170, sort: true
                        },
                        {
                            toolbar: '#ToolbarPermissionTableTpl',
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
        <script type="text/html" id="ToolbarPermissionTableTpl">
            <x-admin::table.row-action data-event-dbclick data-width="600px" data-title="编辑权限"
                                        data-modal='<%=taAdmin%>/permission/<%d.id%>'>
                编 辑
            </x-admin::table.row-action>

            <x-admin::table.row-action data-confirm="确定要删除权限吗?"
                                        data-action='<%=taAdmin%>/permission'
                                        data-value="id#<%d.id%>;_method#delete"
                                        type="danger">删 除
            </x-admin::table.row-action>
        </script>
    </x-slot:script>
</x-admin::table>
