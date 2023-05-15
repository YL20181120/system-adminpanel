<div class="layui-side">
    <a class="layui-side-target" data-target-menu-type></a>
    <a class="layui-logo layui-elip" href="{{ route('admin.index') }}" title="{{ sysconf('app_name') }}">
        <span class="headimg headimg-no headimg-xs" data-lazy-src="{{ sysconf('site_icon') }}"></span>
        <span
            class="headtxt">{{ sysconf('app_name') }} @if(sysconf('app_version'))
                <sup>{{ sysconf('app_version') }}</sup>
            @endif</span>
    </a>
    <div class="layui-side-scroll">
        <div class="layui-side-icon">
            @foreach($menus as $one)
                <div>
                    <a data-menu-node="m-{{ $one['id'] }}" data-open="{{ $one['url'] }}"
                       data-target-tips="{{ $one['title'] ?? '' }}">
                        @if (!blank($one['icon']))
                            <i class="{{ $one['icon'] }}"></i>
                        @endif
                        <span>{{ $one['title'] ?? '' }}</span>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="layui-side-tree">
            @foreach($menus as $one)
                @if (count($one['sub'] ?? []) > 0)
                    <ul class="layui-nav layui-nav-tree layui-hide" data-menu-layout="m-{{ $one['id'] }}">
                        @foreach($one['sub'] ?? [] as $two)
                            @if (count($two['sub'] ?? []) == 0)
                                <li class="layui-nav-item">
                                    <a data-target-tips="{{ $two['title'] ?? '' }}"
                                       data-menu-node="m-{{ $one['id'] }}-{{ $two['id'] }}"
                                       data-open="{{ $two['url'] }}">
                                        <span
                                            class='nav-icon {{ $two['icon'] ?? 'layui-icon layui-icon-senior' }}'></span>
                                        <span class="nav-text">{{ $two['title'] ?? '' }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="layui-nav-item" data-submenu-layout='m-{{ $one['id'] }}-{{ $two['id'] }}'>
                                    <a data-target-tips="{{ $two['title'] ?? '' }}">
                                <span
                                    class='nav-icon layui-hide {{ $two['icon'] ?? 'layui-icon layui-icon-triangle-d' }}'></span>
                                        <span class="nav-text">{{ $two['title'] ?? '' }}</span>
                                    </a>
                                    <dl class="layui-nav-child">
                                        @foreach($two['sub'] ?? [] as $thr)
                                            <dd>
                                                <a data-target-tips="{{ $thr['title'] ?? '' }}"
                                                   data-open="{{ $thr['url'] }}"
                                                   data-menu-node="m-{{ $one['id'] }}-{{ $two['id'] }}-{{ $thr['id'] }}">
                                        <span
                                            class='nav-icon {{ $thr['icon'] ?? 'layui-icon layui-icon-senior' }}'></span>
                                                    <span class="nav-text">{{ $thr['title'] }}</span>
                                                </a>
                                            </dd>
                                        @endforeach
                                    </dl>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </div>
    </div>
</div>
