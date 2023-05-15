<x-admin::table>
    <x-slot name="title">
        {{ __('Files') }}
    </x-slot>
    <x-slot name="button">
        <x-admin::table.button
            data-table-id="FileTable"
            data-load="{{ route('admin.file.distinct') }}"
            data-method="post"
            type="primary">
            Clean
        </x-admin::table.button>
        <x-admin::table.button
            data-confirm="{{ __('admin::admin.delete_confirmation',['attribute' => __('Files')]) }}"
            data-table-id="FileTable"
            data-action="{{ route('admin.file.destroy', '0') }}"
            data-rule="id#{id};_method#delete"
            type="danger">
            {{ __('admin::admin.batch_delete') }}
        </x-admin::table.button>
    </x-slot>
    <div class="think-box-shadow">
        @include('admin::file.index_search')
        <table id="FileTable" data-url="{{ request()->url() }}" data-target-search="form.form-search"></table>
    </div>
    <x-slot:script>
        <script>
            $(function () {
                $('#FileTable').layTable({
                    even: true, height: 'full',
                    sort: {field: 'id', type: 'desc'},
                    cols: [[
                        {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', width: 80, align: 'center', sort: true},
                        {field: 'name', title: 'Name', width: '12%', align: 'center'},
                        {
                            field: 'hash',
                            title: 'Hash',
                            width: '15%',
                            align: 'center',
                            templet: '<div><code><%d.hash%></code></div>'
                        },
                        {
                            field: 'size',
                            title: 'Size',
                            align: 'center',
                            width: '7%',
                            sort: true,
                            templet: '<div><%-$.formatFileSize(d.size)%></div>'
                        },
                        {field: 'xext', title: 'Ext', align: 'center', width: '7%', sort: true},
                        {
                            field: 'xurl', title: 'View', width: '7%', align: 'center', templet: function (d) {
                                if (typeof d.mime === 'string' && /^image\//.test(d.mime)) {
                                    return laytpl('<div><a target="_blank" data-tips-hover data-tips-image="<%d.xurl%>"><i class="layui-icon layui-icon-picture"></i></a></div>').render(d)
                                }
                                if (typeof d.mime === 'string' && /^video\//.test(d.mime)) {
                                    return laytpl('<div><a target="_blank" data-video-player="<%d.xurl%>" data-tips-text="播放视频"><i class="layui-icon layui-icon-video"></i></a></div>').render(d);
                                }
                                if (typeof d.mime === 'string' && /^audio\//.test(d.mime)) {
                                    return laytpl('<div><a target="_blank" data-video-player="<%d.xurl%>" data-tips-text="播放音频"><i class="layui-icon layui-icon-headset"></i></a></div>').render(d);
                                }
                                return laytpl('<div><a target="_blank" href="<%d.xurl%>"  data-tips-text="查看下载"><i class="layui-icon layui-icon-file"></i></a></div>').render(d);
                            }
                        },
                        {
                            field: 'isfast', title: 'Type', align: 'center', width: '8%', templet: function (d) {
                                return d.isfast ? '<b class="color-green">Fast</b>' : '<b class="color-blue">Normal</b>';
                            }
                        },
                        {field: 'created_at', title: 'Upload At', align: 'center', width: '15%', sort: true},
                        {toolbar: '#toolbar', title: 'Handle', align: 'center', minWidth: 150, fixed: 'right'}
                    ]]
                });
            });
        </script>
        <script type="text/html" id="toolbar">
            <x-admin::table.row-action data-modal="{{ admin_route('admin.file.update', '<%d.id%>') }}"
                                        data-title="编辑文件信息">
                {{ __('admin::admin.edit') }}
            </x-admin::table.row-action>
            <x-admin::table.row-action
                data-action="{{ admin_route('admin.file.destroy', '<%d.id%>')  }}"
                data-value="id#<%d.id%>;_method#delete"
                type="danger">删 除
            </x-admin::table.row-action>
        </script>
    </x-slot:script>
</x-admin::table>
