<x-admin::app-layout>
    <x-slot name="title">Login</x-slot>
    <x-slot:style>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <script>if (location.href.indexOf('#') > -1) location.replace(location.href.split('#')[0])</script>
        <link rel="stylesheet" href="{{ asset('vendor/admin/theme/css/login.css') }}">
    </x-slot:style>
    <x-slot:body>
        <div class="login-container">
            <div class="header flex justify-end sm:hidden px-20 items-end">
                <div>
                    <x-admin::switch-locale/>
                </div>
            </div>
            <form data-login-form onsubmit="return false" method="post" autocomplete="off"
                  style=" background-color:rgba(255,255,255,0.2); border-radius: 15px; padding: 35px; ">
                <input type="hidden" name="uniqid" value="">
                <h2 class="notselect">
                    {{ sysconf('app_name') }}
                </h2>
                <ul>
                    <li class="username">
                        <label class="label-required-null">
                            <i class="layui-icon layui-icon-email"></i>
                            <input class="layui-input" required pattern="^\S{4,}$"
                                   vali-name="{{ __('admin::login.username') }}" name="email"
                                   autofocus autocomplete="off" placeholder="{{ __('admin::login.username') }}">
                        </label>
                    </li>
                    <li class="password">
                        <label class="label-required-null">
                            <i class="layui-icon layui-icon-password"></i>
                            <input class="layui-input" required pattern="^\S{4,}$"
                                   vali-name="{{ __('admin::login.password') }}" name="password"
                                   maxlength="32" type="password" autocomplete="off"
                                   placeholder="{{ __('admin::login.password') }}">
                        </label>
                    </li>
                    <li class="flex verify layui-hide">
                        <label class="inline-block relative label-required-null">
                            <i class="layui-icon layui-icon-picture-fine"></i>
                            <input class="layui-input" required pattern="^\d+$" name="verify" maxlength="4"
                                   autocomplete="off" vali-name="{{ __('admin::login.captcha') }}"
                                   placeholder="{{ __('admin::login.captcha') }}">
                        </label>
                        <div data-captcha="{{ route('admin.captcha', ['config' => 'system']) }}"
                             data-field-verify="verify"
                             data-field-uniqid="uniqid" data-captcha-type="LoginCaptcha"></div>
                    </li>
                    <li class="text-center padding-top-20">
                        <button type="submit" class="layui-btn layui-disabled full-width"
                                data-form-loaded="{{ __('admin::login.login_now') }}">
                            {{ __('admin::login.loading') }}
                        </button>
                    </li>
                </ul>
            </form>
        </div>
    </x-slot:body>

    <x-slot:script>
        <script src="{{ asset('vendor/admin/login.js') }}"></script>
    </x-slot:script>
</x-admin::app-layout>
