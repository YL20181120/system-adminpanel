<x-admin::main>
    <x-slot:title>系统参数配置</x-slot:title>
    <x-slot:button>
        <x-admin::table.button data-modal="{{ route('admin.config.admin') }}">
            修改系统参数
        </x-admin::table.button>
    </x-slot:button>

    <div class="layui-card padding-20 shadow">
        <div class="layui-card-header notselect">
            <b>富编辑器</b><span class="color-desc font-s12 padding-left-5">Rich Text Editor</span>
        </div>
        <div class="layui-card-body layui-clear">
            <div class="layui-btn-group shadow-mini nowrap">
                @if (!in_array(sysconf('base.editor'), ['ckeditor4','ckeditor5','auto']))
                    @php
                        sysconf('base.editor', 'ckeditor4')
                    @endphp
                @endif
                @foreach(['ckeditor4'=>'CKEditor4','ckeditor5'=>'CKEditor5','auto'=>'自适应模式'] as $k => $v)
                    @if (sysconf('base.editor') == $k)
                        <a data-title="配置{{$v}}" class="layui-btn layui-btn-sm layui-btn-active">{{$v}}</a>
                    @else
                        <a data-title="配置{{$v}}" data-action="{{ route('admin.admin.editor') }}"
                           data-value="editor#{{$k}}"
                           class="layui-btn layui-btn-sm layui-btn-primary">{{$v}}</a>
                    @endif
                @endforeach
            </div>
            <div class="margin-top-20 nowrap full-width pull-left">
                <p><b>CKEditor4</b>：旧版本编辑器，对浏览器兼容较好，但内容编辑体验稍有不足。</p>
                <p><b>CKEditor5</b>：新版本编辑器，只支持新特性浏览器，对内容编辑体验较好，推荐使用。</p>
                <p><b>自适应模式</b>：优先使用新版本编辑器，若浏览器不支持新版本时自动降级为旧版本编辑器。</p>
            </div>
        </div>
    </div>

    <div class="layui-card padding-20 shadow">
        <div class="layui-card-header notselect">
            <b>存储引擎</b><span class="color-desc font-s12 padding-left-5">Storage Engine</span>
        </div>
        <!-- 初始化存储配置 -->
        @if( !sysconf('storage.type'))
            @php sysconf('storage.type','local');@endphp
        @endif
        @if(!sysconf('storage.link_type'))
            @php sysconf('storage.link_type','none');@endphp
        @endif
        @if(!sysconf('storage.name_type'))
            @php sysconf('storage.name_type','xmd5');@endphp
        @endif
        @if(!sysconf('storage.allow_exts'))
            @php sysconf('storage.allow_exts','doc,gif,ico,jpg,mp3,mp4,p12,pem,png,rar,xls,xlsx');@endphp
        @endif
        @if(!sysconf('storage.local_http_protocol'))
            @php sysconf('storage.local_http_protocol','http');@endphp
        @endif

        <div class="layui-card-body layui-clear">
            <div class="layui-btn-group shadow-mini nowrap">
                @foreach(['local'=>'本地服务器存储'] as $k => $v)
                    <a data-title="配置{{$v}}" data-modal="{{ route('admin.config.storage', ['type' => $k]) }}"
                        @class(["layui-btn layui-btn-sm", 'layui-btn-active' => sysconf('storage.type') == $k])>{{$v}}</a>
                @endforeach
            </div>
            <div class="margin-top-20 nowrap full-width pull-left">
                <p><b>本地服务器存储</b>：文件直接上传到本地服务器的 `storage/app/public`
                    目录，不支持大文件上传，占用服务器磁盘空间，访问时消耗服务器带宽流量。
                </p>
                {{--                <p><b>七牛云对象存储</b>：文件直接上传到七牛云存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持--}}
                {{--                    CDN 加速访问，访问量大时推荐使用。</p>--}}
                {{--                <p><b>又拍云USS存储</b>：文件直接上传到又拍云 USS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持--}}
                {{--                    CDN 加速访问，访问量大时推荐使用。</p>--}}
                {{--                <p><b>阿里云OSS存储</b>：文件直接上传到阿里云 OSS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持--}}
                {{--                    CDN 加速访问，访问量大时推荐使用。</p>--}}
                {{--                <p><b>腾讯云COS存储</b>：文件直接上传到腾讯云 COS 存储空间，支持大文件上传，不占用服务器空间及服务器带宽流量，支持--}}
                {{--                    CDN 加速访问，访问量大时推荐使用。</p>--}}
            </div>
        </div>
    </div>


    <div class="layui-card padding-20 shadow">
        <div class="layui-card-header notselect">
            <b>系统参数</b><span class="color-desc font-s12 padding-left-5">admin Parameter</span>
        </div>
        <div class="layui-card-body">
            <div class="layui-form-item">
                <div class="help-label"><b>网站名称</b>Website</div>
                <label class="relative block">
                    <input readonly value="{{ sysconf('site_name') }}" class="layui-input layui-bg-gray">
                    <a data-copy="{{ sysconf('site_name') }}"
                       class="layui-icon layui-icon-release input-right-icon"></a>
                </label>
                <div class="help-block">网站名称及网站图标，将显示在浏览器的标签上。</div>
            </div>
            <div class="layui-form-item">
                <div class="help-label"><b>管理程序名称</b>Name</div>
                <label class="relative block">
                    <input readonly value="{{ sysconf('app_name') }}" class="layui-input layui-bg-gray">
                    <a data-copy="{{ sysconf('app_name') }}" class="layui-icon layui-icon-release input-right-icon"></a>
                </label>
                <div class="help-block">管理程序名称，将显示在后台左上角标题。</div>
            </div>
            <div class="layui-form-item">
                <div class="help-label"><b>管理程序版本</b>Version</div>
                <label class="relative block">
                    <input readonly value="{{ sysconf('app_version') }}" class="layui-input layui-bg-gray">
                    <a data-copy="{{ sysconf('app_version') }}"
                       class="layui-icon layui-icon-release input-right-icon"></a>
                </label>
                <div class="help-block">管理程序版本，将显示在后台左上角标题。</div>
            </div>
            {{--            <div class="layui-form-item">--}}
            {{--                <div class="help-label"><b>公网备案号</b>Baian</div>--}}
            {{--                <label class="relative block">--}}
            {{--                    <input readonly value="{{ sysconf('beian')?:'-' }}" class="layui-input layui-bg-gray">--}}
            {{--                    <a data-copy="{{ sysconf('beian') }}" class="layui-icon layui-icon-release input-right-icon"></a>--}}
            {{--                </label>--}}
            {{--                <p class="help-block">公网备案号，可以在 <a target="_blank"--}}
            {{--                                                           href="https://beian.miit.gov.cn">备案管理中心</a>--}}
            {{--                    查询获取，将在登录页面下面显示。</p>--}}
            {{--            </div>--}}
            {{--            <div class="layui-form-item">--}}
            {{--                <div class="help-label"><b>网站备案号</b>Miitbeian</div>--}}
            {{--                <label class="relative block">--}}
            {{--                    <input readonly value="{{ sysconf('miitbeian')?:'-' }}" class="layui-input layui-bg-gray">--}}
            {{--                    <a data-copy="{{ sysconf('miitbeian') }}"--}}
            {{--                       class="layui-icon layui-icon-release input-right-icon"></a>--}}
            {{--                </label>--}}
            {{--                <div class="help-block">网站备案号，可以在 <a target="_blank"--}}
            {{--                                                             href="https://beian.miit.gov.cn">备案管理中心</a>--}}
            {{--                    查询获取，将显示在登录页面下面。--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="layui-form-item">
                <div class="help-label"><b>网站版权信息</b>Copyright</div>
                <label class="relative block">
                    <input readonly value="{{ sysconf('site_copy') }}" class="layui-input layui-bg-gray">
                    <a data-copy="{{ sysconf('site_copy') }}"
                       class="layui-icon layui-icon-release input-right-icon"></a>
                </label>
                <div class="help-block">网站版权信息，在后台登录页面显示版本信息并链接到备案到信息备案管理系统。</div>
            </div>
            <div class="layui-form-item">
                <div class="help-label"><b>运行时区</b>Timezone</div>
                <label class="relative block">
                    <input readonly
                           value="{{ \Illuminate\Support\Carbon::now()->timezone }}"
                           class="layui-input layui-bg-gray">
                </label>
            </div>
            <div class="layui-form-item">
                <div class="help-label"><b>运行货币</b>Currency</div>
                <label class="relative block">
                    <input readonly
                           value="{{ \admin\Services\CurrencyService::currency()['symbol'] }} {{ \admin\Services\CurrencyService::currency()['name'] }}"
                           class="layui-input layui-bg-gray">
                </label>
            </div>
        </div>
    </div>


    <div class="layui-card padding-20 shadow">
        <div class="layui-card-header notselect">
            <b>系统信息</b><span class="color-desc font-s12 padding-left-5">admin Information</span>
        </div>
        <div class="layui-card-body">
            <table class="layui-table" lay-even>
                <tbody>
                <tr>
                    <th class="nowrap text-center">核心框架</th>
                    <td><a target="_blank" href="https://laravel.com/">Laravel
                            Version {{ \Illuminate\Support\Facades\App::version() }}</a></td>
                </tr>
                <tr>
                    <th class="nowrap text-center">操作系统</th>
                    <td>{{ php_uname() }}</td>
                </tr>
                <tr>
                    <th class="nowrap text-center">运行环境</th>
                    <td>{{ucfirst(request()->server('SERVER_SOFTWARE',php_sapi_name()))}} & PHP
                        {{ phpversion() }}
                    </td>
                </tr>
                @if (class_exists(\Stancl\Tenancy\Tenancy::class))
                    <tr>
                        <th class="nowrap text-center">Tenant ID</th>
                        <td>
                            {{ tenant('id') }}
                        </td>
                    </tr>
                    <tr>
                        <th class="nowrap text-center">Tenant Name</th>
                        <td>
                            {{ tenant('name') }}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

</x-admin::main>
