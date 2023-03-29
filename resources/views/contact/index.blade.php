<x-system::table>
    <x-slot:title>手机号管理</x-slot:title>

    <x-slot:button>
        <x-system::table.button data-confirm="确定将这些手机号码设置为有效吗？" data-table-id="ContactTable"
                                data-action="{{ route('system.contact.state', 'whatsapp') }}"
                                data-rule="id#{id};_method#post"
                                type="warm">
            批量更新 WhatsAPP
        </x-system::table.button>
        <x-system::table.button data-confirm="确定要删除这些手机号码？" data-table-id="ContactTable"
                                data-action="{{ route('system.contact.destroy') }}"
                                data-rule="id#{id};_method#delete"
                                type="danger">
            批量删除
        </x-system::table.button>
    </x-slot:button>
    <div class="think-box-shadow">
        <table id="ContactTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#ContactTable').layTable({
                    even: true, height: 'full', page: true,
                    sort: {field: 'created_at', type: 'desc'},

                    cols: [[
                        {checkbox: true, field: 'sps'},
                        {
                            field: 'id',
                            title: 'ID',
                            width: 80,
                            align: 'center',
                        },
                        {
                            field: 'countryCode',
                            title: '国际区号',
                            width: 80,
                            align: 'center',
                        },
                        {
                            field: 'nationalNumber',
                            title: '手机号码',
                            minWidth: 220,
                        },
                        {
                            field: 'whatsapp_checked',
                            title: 'WhatsApp 空号',
                            minWidth: 120,
                            align: 'center',
                            templet: '#whatsapp_checkedSwitchTpl'
                        },
                        {
                            field: 'whatsapp_checked_at',
                            title: 'WhatsApp 空号检测时间',
                            minWidth: 120,
                            align: 'center',
                            sort: true
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
                            $('#ContactTable').trigger('reload');
                        }); else {
                            $('#ContactTable').trigger('reload');
                        }
                        return false;
                    }, false);
                });
            });
        </script>

        <script type="text/html" id="whatsapp_checkedSwitchTpl">
            @{{# if(d.whatsapp_checked == 0) { }}
            <input type="checkbox" value="@{{d.id}}" lay-text="有效|空号" lay-filter="whatsapp_checkedSwitch"
                   lay-skin="switch" @{{d.whatsapp_checked>0?'checked':''}} @{{d.whatsapp_checked>0?'disabled':''}} >
            @{{# }else{ }}
            <b class="color-green">有效</b>
            @{{# } }}
        </script>

        <script type="text/html" id="toolbar">
            <x-system::table.row-action data-confirm="确定要删除菜单吗？"
                                        data-action="{{ route('system.contact.destroy') }}"
                                        data-value="id#@{{d.id}};_method#delete"
                                        type="danger">删 除
            </x-system::table.row-action>
        </script>
    </x-slot:script>
</x-system::table>
