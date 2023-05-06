<div class="layui-header">
    <ul class="layui-nav layui-layout-left">
        <li class="layui-nav-item" lay-unselect>
            <a class="text-center" data-target-menu-type>
                <i class="layui-icon layui-icon-spread-left"></i>
            </a>
        </li>
        <li class="layui-nav-item" lay-unselect>
            <a class="layui-logo-hide layui-elip" href="{{ route('system.index') }}" title="{{ sysconf('app_name') }}">
                <span class="headimg headimg-no headimg-xs" data-lazy-src="{{ sysconf('site_icon') }}"></span>
            </a>
        </li>
        @foreach($menus as $one)
            <li class="layui-nav-item">
                <a data-menu-node="m-{{ $one['id'] }}"
                   data-open="{{ $one['url'] }}"><span>{{ $one['title'] }}</span></a>
            </li>
        @endforeach
    </ul>
    <ul class="layui-nav layui-layout-right">
        <li lay-unselect class="layui-nav-item"><a data-reload><i class="layui-icon layui-icon-refresh-3"></i></a></li>
        @auth
            <li class="layui-nav-item">
                <dl class="layui-nav-child">
                    <dd lay-unselect><a data-modal="{{ route('system.userinfo') }}"><i
                                class="layui-icon layui-icon-set-fill"></i> 基本资料</a></dd>
                    <dd lay-unselect><a data-modal="{{ route('system.password') }}"><i
                                class="layui-icon layui-icon-component"></i> 安全设置</a></dd>
                    <dd lay-unselect><a data-modal="{{ route('system.sessions') }}"><i
                                class="layui-icon layui-icon-component"></i>Sessions</a></dd>
                    <dd lay-unselect><a data-modal="{{ route('system.two-factor-auth') }}"><i
                                class="layui-icon layui-icon-component"></i> 两步验证</a></dd>
                    <dd lay-unselect><a data-open="{{ route('system.api-token.index',absolute: false) }}"><i
                                class="layui-icon layui-icon-component"></i>Api Tokens</a></dd>
                    {{--                    {if isset($super) and $super}--}}
                    {{--                    <dd lay-unselect><a data-load="{:sysuri('admin/api.system/push')}"><i--}}
                    {{--                                class="layui-icon layui-icon-template-1"></i> 缓存加速</a></dd>--}}
                    {{--                    <dd lay-unselect><a data-load="{:sysuri('admin/api.system/clear')}"><i--}}
                    {{--                                class="layui-icon layui-icon-fonts-clear"></i> 清理缓存</a></dd>--}}
                    {{--                    {/if}--}}
                    <dd lay-unselect><a data-width="520px" data-modal="{{ route('system.theme') }}"><i
                                class="layui-icon layui-icon-theme"></i> 配色方案</a></dd>
                    <dd lay-unselect><a data-load="{{ url('system/logout') }}" data-confirm="确定要退出登录吗？"
                                        data-method="post"><i
                                class="layui-icon layui-icon-release"></i> 退出登录</a></dd>
                </dl>
                <a class="layui-elip" style="min-width: 132px;text-align: center">
                    <span>{{ auth()->user()->username ?? '' }}</span>
                </a>
            </li>
        @endauth
    </ul>
</div>
