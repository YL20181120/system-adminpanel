<x-admin::table>
    <x-slot:title>Api Tokens</x-slot:title>
    <x-slot:button>
        <x-admin::table.button data-table-id="ApiTokens" data-modal="{{ route('admin.api-token.create') }}"
                                data-width="600px">
            添加
        </x-admin::table.button>
        <x-admin::table.button data-table-id="ApiTokens" data-action="{{ route('admin.api-token.destroy') }}"
                                data-rule="id#{id};_method#delete"
                                data-confirm="确定要批量 Token 吗？"
                                type="danger">
            删除
        </x-admin::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        <table id="ApiTokens" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#ApiTokens').layTable({
                    even: true, height: 'full',
                    page: @js($page),
                    cols: [[
                        {checkbox: true, fixed: true},
                        {
                            field: 'id', title: 'ID', align: 'center'
                        },
                        {
                            field: 'name', title: 'Name', align: 'center', minWidth: 140
                        },
                        {
                            field: 'abilities_str', title: 'Abilities', align: 'center', minWidth: 140
                        },
                        {
                            field: 'last_used_at', title: 'LAST USED AGO', align: 'center', minWidth: 170, sort: true,
                            templet: '<div><%d.last_used_ago%></div>'
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
            <x-admin::table.row-action data-event-dbclick data-width="600px" data-title="编辑权限"
                                        data-modal='<%=taAdmin%>/api_tokens/<%d.id%>/permissions'>Permissions
            </x-admin::table.row-action>
            <x-admin::table.row-action data-confirm="确定要删除 Token 吗?"
                                        data-action="{{ route('admin.api-token.destroy') }}"
                                        data-value="id#<%d.id%>;_method#delete"
                                        type="danger">删 除
            </x-admin::table.row-action>
        </script>
    </x-slot:script>
</x-admin::table>
