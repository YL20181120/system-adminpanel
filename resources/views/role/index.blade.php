<x-admin::table>
    <x-slot:title>Role</x-slot:title>
    <x-slot:button>
        <x-admin::table.button data-table-id="role" data-modal="{{ route('admin.role.create') }}" data-width="600px">
            添加
        </x-admin::table.button>

        <x-admin::table.button data-table-id="role" data-action="{{ route('admin.role.destroy') }}"
                                data-rule="id#{id};_method#delete"
                                data-confirm="确定要批量 Role 吗？"
                                type="danger">
            删除
        </x-admin::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        @include('admin::role.index_search')
        <table id="role" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#role').layTable({
                    even: true, height: 'full',
                    cols: [[
                        {checkbox: true, fixed: true},
                        {
                            field: 'guard_name', title: 'Guard', align: 'center', minWidth: 140
                        }, {
                            field: 'name', title: 'Role', align: 'center', minWidth: 140
                        },
                        {
                            field: 'created_at', title: '创建时间', align: 'center', minWidth: 170, sort: true
                        }, {
                            field: 'updated_at', title: '更新时间', align: 'center', minWidth: 170, sort: true
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
            <x-admin::table.row-action data-event-dbclick data-width="600px" data-title="授 权" type="info"
                                        data-open='<%=taAdmin%>/role/<%d.id%>/apply'>授 权
            </x-admin::table.row-action>

            <x-admin::table.row-action data-event-dbclick data-width="600px" data-title="编辑权限"
                                        data-modal='<%=taAdmin%>/role/<%d.id%>'>编 辑
            </x-admin::table.row-action>
            <x-admin::table.row-action data-confirm="确定要删除权限吗?"
                                        data-action="{{ route('admin.role.destroy') }}"
                                        data-value="id#<%d.id%>;_method#delete"
                                        type="danger">删 除
            </x-admin::table.row-action>
        </script>
    </x-slot:script>
</x-admin::table>
