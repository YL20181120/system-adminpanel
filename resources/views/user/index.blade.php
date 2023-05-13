<x-system::table>
    <x-slot:title>用户管理</x-slot:title>
    <x-slot:button>
        @if ($type == 'index')
            <x-system::table.button data-table-id="UserTable" data-modal="{{ route('system.user.create') }}">
                添加用户
            </x-system::table.button>
            <x-system::table.button data-confirm="确定要禁用这些用户吗？" data-table-id="UserTable"
                                    data-action="{{ route('system.user.state') }}" data-rule="id#{id};status#0"
                                    type="danger">
                批量禁用
            </x-system::table.button>
        @else
            <x-system::table.button data-confirm="确定要禁用这些用户吗？" data-table-id="UserTable"
                                    data-action="{{ route('system.user.state') }}" data-rule="id#{id};status#1"
                                    type="success">
                批量恢复
            </x-system::table.button>
            <x-system::table.button data-confirm="确定永久删除这些账号吗？" data-table-id="UserTable"
                                    data-action="{{ route('system.user.destroy') }}"
                                    data-rule="id#{id};_method#delete"
                                    type="danger">
                批量删除
            </x-system::table.button>
        @endif
    </x-slot:button>
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @foreach(['index'=>'系统用户','recycle'=>'回 收 站'] as $k=>$v)
                @if (isset($type) and $type == $k)
                    <li class="layui-this"
                        data-open="{{ route('system.user.index', ['type' => $k], false) }}">{{$v}}</li>
                @else
                    <li data-open="{{ route('system.user.index', ['type' => $k], false) }}">{{$v}}</li>
                @endif
            @endforeach
        </ul>
        <div class="layui-tab-content">
            @include('system::user.index_search')
            <table id="UserTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
        </div>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#UserTable').layTable({
                    even: true, height: 'full', page: @js($page),
                    sort: {field: 'created_at', type: 'desc'},
                    where: {type: '{{ $type }}'},
                    filter: function (items) {
                        var type = this.where.type;
                        return items.filter(function (item) {
                            return !(type === 'index' && parseInt(item.status) === 0);
                        });
                    },
                    cols: [[
                        {checkbox: true, field: 'sps', fixed: 'left'},
                        {
                            field: 'id',
                            title: 'ID',
                            align: 'center',
                            fixed: 'left'
                        },
                        {
                            field: 'email',
                            title: 'Email',
                            minWidth: 220,
                            sort: true,
                            templet: '<div><a href="mailto:<%d.email%>" target="_blank"><%d.email%></a></div>'
                        },
                        {field: 'username', title: 'Username', minWidth: 200, sort: true,},
                        {
                            field: 'phone',
                            title: 'Phone',
                            minWidth: 200,
                            templet: '<div><a href="tel:<%d.phone%>" target="_blank"><%d.phone%></a></div>'
                        },
                        {
                            field: 'status',
                            title: '账号状态',
                            align: 'center',
                            minWidth: 110,
                            templet: '#StatusSwitchTpl'
                        },
                            @if ($type == 'index')
                        {
                            field: 'last_login_at', title: 'Last Login At', minWidth: 200
                        },
                        {field: 'last_login_ip', title: 'Last Login IP', minWidth: 200},
                            @else
                        {
                            field: 'ban_at', title: 'Ban At', minWidth: 200
                        },
                            @endif
                        {
                            field: 'created_at', title: 'created_at', minWidth: 200
                        },
                        {toolbar: '#toolbar', title: '操作面板', minWidth: 260, align: 'center', fixed: 'right'},
                    ]]
                });
                layui.form.on('switch(UserStatusSwitch)', function (obj) {
                    var data = {id: obj.value, status: obj.elem.checked > 0 ? 1 : 0};
                    $.form.load("{{ route('system.user.state') }}", data, 'post', function (ret) {
                        if (ret.code < 1) $.msg.error(ret.info, 3, function () {
                            $('#UserTable').trigger('reload');
                        }); else {
                            $('#UserTable').trigger('reload')
                        }
                        return false;
                    }, false);
                });
            });
        </script>

        <script type="text/html" id="StatusSwitchTpl">
            <input type="checkbox" value="<%d.id%>" lay-text="已启用|已禁用" lay-filter="UserStatusSwitch"
                   lay-skin="switch" <%d.ban_at==null?'checked':''%>>
            <%-d.ban_at==null ? '<b class="color-green">已启用</b>' : '<b class="color-red">已禁用</b>'%>
        </script>

        <?php
        /** @var \Lab404\Impersonate\Services\ImpersonateManager $app */
        $app = app('impersonate');
        $impersonator = $app->getImpersonator();
        ?>


        <script type="text/html" id="toolbar">
            @if ($type === 'index')
                <!-- Add -->
                <x-system::table.row-action data-title="编辑用户"
                                            data-modal='<%=taAdmin%>/user/<%d.id%>/edit' type="success">编 辑
                </x-system::table.row-action>
                <%# if(d.id!='{{ auth()->user()->getAuthIdentifier() }}' && d.id!={{ $impersonator ? $impersonator->getAuthIdentifier() : '0' }}) { %>
                <x-system::table.row-action
                    data-href="javascript:location.href=route('system.impersonate', {'id': '<%d.id%>'})">Impersonate
                </x-system::table.row-action>
                <%#} %>
                <x-system::table.row-action data-title="设置密码"
                                            data-modal="<%=taAdmin%>/user/<%d.id%>/password" type="normal">密
                    码
                </x-system::table.row-action>
                <!-- End Add -->
            @else
                Delete
                <x-system::table.row-action data-title="编辑用户"
                                            data-modal='<%=taAdmin%>/user/<%d.id%>/edit'>编 辑
                </x-system::table.row-action>
                <x-system::table.row-action data-confirm="确定要永久删除此账号吗？"
                                            data-action="route('system.user.destroy')"
                                            data-value="id#<%d.id%>;_method#delete"
                                            type="danger">删 除
                </x-system::table.row-action>
            @endif
        </script>
    </x-slot:script>
</x-system::table>
