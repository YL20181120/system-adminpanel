<x-system::app-layout>
    <x-slot name="title">Login</x-slot>
    <x-slot:style>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <script>if (location.href.indexOf('#') > -1) location.replace(location.href.split('#')[0])</script>
        <link rel="stylesheet" href="{{ asset('vendor/system/theme/css/login.css') }}">
    </x-slot:style>
    <x-slot:body>
        <div class="login-container"
             style="background-image: url({{ asset('vendor/system/theme/img/login/background.svg') }})">
            <div class="header notselect layui-hide-xs">
                <a href="{{ url('/') }}" class="title">{{ sysconf('app_name') }}
                    <span>{{ sysconf('app_version') }}</span></a>
            </div>
            <form data-login-form onsubmit="return false" method="post" class="layui-anim layui-anim-upbit"
                  autocomplete="off">
                <input type="hidden" name="uniqid" value="">
                <h2 class="notselect">{{ sysconf('login_name') ?:'系统管理' }}</h2>
                <ul>
                    <li class="username">
                        <label class="label-required-null">
                            <i class="layui-icon layui-icon-email"></i>
                            <input class="layui-input" required pattern="^\S{4,}$" vali-name="邮箱" name="email"
                                   autofocus autocomplete="off" placeholder="登录账号">
                        </label>
                    </li>
                    <li class="password">
                        <label class="label-required-null">
                            <i class="layui-icon layui-icon-password"></i>
                            <input class="layui-input" required pattern="^\S{4,}$" vali-name="登录密码" name="password"
                                   maxlength="32" type="password" autocomplete="off" placeholder="登录密码">
                        </label>
                    </li>
                    <li class="flex verify layui-hide">
                        <label class="inline-block relative label-required-null">
                            <i class="layui-icon layui-icon-picture-fine"></i>
                            <input class="layui-input" required pattern="^\d+$" name="verify" maxlength="4"
                                   autocomplete="off" vali-name="验证码" placeholder="验证码">
                        </label>
                        <div data-captcha="{{ route('system.captcha', ['config' => 'system']) }}"
                             data-field-verify="verify"
                             data-field-uniqid="uniqid" data-captcha-type="LoginCaptcha"></div>
                    </li>
                    <li class="text-center padding-top-20">
                        <button type="submit" class="layui-btn layui-disabled full-width" data-form-loaded="立即登入">
                            正在载入
                        </button>
                    </li>
                </ul>
            </form>
            <div class="footer notselect">
                <p class="layui-hide-xs">推荐使用 <a target="_blank" href="https://www.google.cn/chrome">Google
                        Chrome</a> 或 <a target="_blank" href="https://www.microsoft.com/zh-cn/edge#platform">Microsoft
                        Edge</a> 浏览器访问</p>
                {{ sysconf('site_copy') }}
                @if(sysconf('beian'))
                    <span class="padding-5">|</span><a target="_blank"
                                                       href="https://beian.miit.gov.cn/">{{ sysconf('beian') }}</a>
                @endif
                @if(sysconf('miitbeian'))
                    <span class="padding-5">|</span><a target="_blank"
                                                       href="https://beian.miit.gov.cn/">{{ sysconf('miitbeian') }}</a>
                @endif
            </div>
        </div>
    </x-slot:body>

    <x-slot:script>
        <script src="{{ asset('vendor/system/login.js') }}"></script>
    </x-slot:script>
</x-system::app-layout>
