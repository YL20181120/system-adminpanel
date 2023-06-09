<x-admin::table>
    <x-slot name="title">
        {{ __('Logs') }}
    </x-slot>
    <x-slot name="button">
        <x-admin::table.button
            data-confirm="{{ __('admin::admin.delete_confirmation',['attribute' => __('Logs')]) }}"
            data-table-id="LogTable"
            data-action="{{ route('admin.log.destroy', '0') }}"
            data-rule="id#{id};_method#delete"
            type="danger">
            {{ __('admin::admin.batch_delete') }}
        </x-admin::table.button>
    </x-slot>
    <div class="think-box-shadow">
        @include('admin::log.index_search')
        <table id="LogTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                $('#LogTable').layTable({
                    even: true, height: 'full',
                    sort: {field: 'id', type: 'desc'},
                    cols: [[
                        {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', width: 80, align: 'center', sort: true},
                        {field: 'username', title: 'Username', width: '12%', align: 'center'},
                        {field: 'uri', title: 'Path', width: '12%', align: 'left'},
                        {field: 'method', title: 'Method', width: '12%', align: 'left'},
                        {field: 'geoip', title: 'IP', width: '12%', align: 'left'},
                        {
                            field: 'user_agent',
                            title: 'User Agent',
                            width: '12%',
                            align: 'left',
                            templet: function (d) {
                                return laytpl('<div><%d.platform%> <%d.browser%></div>').render(d.user_agent)
                            }
                        },
                        {field: 'created_at', title: 'Created At', align: 'center', width: '15%', sort: true},
                        {toolbar: '#toolbar', title: 'Handle', align: 'center', minWidth: 150, fixed: 'right'}
                    ]]
                });
            });
        </script>
        <script type="text/html" id="toolbar">
            <x-admin::table.row-action
                data-modal="{{ admin_route('admin.log.show', '<%d.id%>')  }}"
                data-full
                data-title="{{ __('admin::admin.view_log') }}"
                type="primary">View
            </x-admin::table.row-action>
            <x-admin::table.row-action
                data-action="{{ admin_route('admin.log.destroy', '<%d.id%>')  }}"
                data-value="id#<%d.id%>;_method#delete"
                type="danger">删 除
            </x-admin::table.row-action>
        </script>
    </x-slot:script>
</x-admin::table>
