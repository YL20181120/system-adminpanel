<x-system::table>
    <x-slot:title>Menu</x-slot:title>
    <x-slot:button>
        <x-system::table.button data-table-id="menu" data-modal="{{ route('system.menu.create') }}">
            添加
        </x-system::table.button>
    </x-slot:button>

    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @foreach(['index'=>'系统菜单','recycle'=>'回 收 站'] as $k=>$v)
                @if (isset($type) and $type == $k)
                    <li class="layui-this"
                        data-open="/system/index.html#{{ route('system.menu.index', ['type' => $k], false) }}">{{$v}}</li>
                @else
                    <li data-open="/system/index.html#{{ route('system.menu.index', ['type' => $k], false) }}">{{$v}}</li>
                @endif
            @endforeach
        </ul>
        <div class="layui-tab-content">
            <table id="menu" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
        </div>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                // 初始化表格组件
                $('#menu').layTable({
                    even: true, height: 'full', page: false,
                    sort: {field: 'sort desc,id', type: 'asc'},
                    where: {type: '{{ $type }}'},
                    filter: function (items) {
                        var type = this.where.type;
                        return items.filter(function (item) {
                            return !(type === 'index' && parseInt(item.status) === 0);
                        });
                    },
                    cols: [[
                        {checkbox: true, field: 'sps'},
                        {field: 'sort', title: '排序权重', width: 100, align: 'center', templet: '#SortInputTpl'},
                        {
                            field: 'icon',
                            title: '图 标',
                            width: 80,
                            align: 'center',
                            templet: '<div><i class="@{{d.icon}} font-s18"></i></div>'
                        },
                        {
                            field: 'title',
                            title: '菜单名称',
                            minWidth: 220,
                            templet: '<div><span class="color-desc">@{{d.spl}}</span>@{{d.title}}</div>'
                        },
                        {field: 'url', title: '跳转链接', minWidth: 200},
                        {
                            field: 'status',
                            title: '菜单状态',
                            minWidth: 120,
                            align: 'center',
                            templet: '#StatusSwitchTpl'
                        },
                        {toolbar: '#toolbar', title: '操作面板', minWidth: 150, align: 'center', fixed: 'right'},
                    ]]
                });

                // 数据状态切换操作
                layui.form.on('switch(StatusSwitch)', function (object) {
                    object.data = {status: object.elem.checked > 0 ? 1 : 0};
                    object.data.id = object.value.split('|')[object.data.status] || object.value;
                    $.form.load("{{ route('system.menu.state') }}", object.data, 'post', function (ret) {
                        if (ret.code < 1) $.msg.error(ret.info, 3, function () {
                            $('#menu').trigger('reload');
                        }); else {
                            $('#menu').trigger('reload');
                        }
                        return false;
                    }, false);
                });
            });
        </script>
        <x-system::table.sort id="SortInputTpl"/>

        <script type="text/html" id="StatusSwitchTpl">
            <?php
            echo sprintf('{{# if( "%s"==\'index\' || (d.spc<1 || d.status<1)){ }}', $type);
            ?>
            <input type="checkbox" value="@{{d.sps}}|@{{d.spp}}" lay-text="已激活|已禁用" lay-filter="StatusSwitch"
                   lay-skin="switch" @{{-d.status>0?'checked':''}}>
            @{{# }else{ }}
            @{{-d.status ? '<b class="color-green">已激活</b>' : '<b class="color-red">已禁用</b>'}}
            @{{# } }}
        </script>

        <script type="text/html" id="toolbar">
            @if ($type == 'index')
                <!-- Add -->
                @{{# if(d.spt<2){ }}
                <x-system::table.row-action data-title="添加系统菜单"
                                            data-modal='/system/menu/create?pid=@{{d.id}}'>添 加
                </x-system::table.row-action>
                @{{# }else{ }}
                <x-system::table.row-action type="disabled">添 加</x-system::table.row-action>
                @{{# } }}
                <!-- End Add -->
                {{--Edit--}}
                <x-system::table.row-action data-event-dbclick data-title="编辑系统菜单"
                                            data-modal='/system/menu/@{{d.id}}'>编 辑
                </x-system::table.row-action>
                {{-- End Edit --}}
            @else
                {{-- Delete--}}
                @{{# if( (d.spc<1 || d.status<1)){ }}
                <x-system::table.row-action data-confirm="确定要删除菜单吗？"
                                            data-action="{{ route('system.menu.destroy') }}"
                                            data-value="id#@{{d.sps}};_method#delete"
                                            type="danger">删 除
                </x-system::table.row-action>
                @{{# }else{ }}
                <x-system::table.row-action type="disabled">删 除
                </x-system::table.row-action>
                @{{# } }}
            @endif
        </script>
    </x-slot:script>
</x-system::table>
