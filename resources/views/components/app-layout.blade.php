<!DOCTYPE html>
@props([
    'title' => config('app.name'),
    'style' => '',
    'script' => '',
    'body' => null
])
<html lang="{{ app()->getLocale() }}">

<head>
    <title>
        {{ $title }} {{ sysconf('site_name') }}
    </title>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=0.4">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/x-icon" href="{{ sysconf('site_icon') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/plugs/layui/css/layui.css') }}?at={{ date('md') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/theme/css/iconfont.css') }}?at={{ date('md') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/theme/css/console.css') }}?at={{ date('md') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin/extra/style.css') }}?at={{ date('md') }}">
    <script src="{{ asset('vendor/admin/plugs/jquery/pace.min.js') }}"></script>
    <script src="{{ route('admin.plugs.script') }}"></script>
    @routes()
    @vite(['resources/js/app.js'])
    {{ $style ?? '' }}
</head>

<body
    class="layui-layout-body layui-layout-theme-{{ !auth('admin')->guest() ? auth('admin')->user()->theme : sysconf('site_theme', default: 'default') }}">

@unless($body !== null)
    <div class="layui-layout layui-layout-admin layui-layout-left-hide">

        <!-- 左则菜单 开始 -->
        <x-admin::left/>
        <!-- 左则菜单 结束 -->

        <!-- 顶部菜单 开始 -->
        <x-admin::top/>
        <!-- 顶部菜单 结束 -->

        <!-- 主体内容 开始 -->
        <div class="layui-body">
            <div class="think-page-body">
                {{ $slot }}
            </div>
            <!-- 页面加载动画 -->
            <div class="think-page-loader layui-hide">
                <div class="loader"></div>
            </div>
        </div>
        <!-- 主体内容 结束 -->
    </div>

    <!-- 加载动画 开始 -->
    {{--    <div class="think-page-loader">--}}
    {{--        <div class="loader"></div>--}}
    {{--    </div>--}}
    <!-- 加载动画 结束 -->
@else
    {{ $body }}
@endunless
<script src="{{ asset('vendor/admin/plugs/layui/layui.js') }}"></script>
<script src="{{ asset('vendor/admin/plugs/require/require.js') }}"></script>
<script src="{{ asset('vendor/admin/admin.js') }}"></script>
<script src="{{ asset('vendor/admin/extra/script.js') }}"></script>
{{ $script ?? '' }}
@includeWhen(!auth()->guest() && auth()->user()->isImpersonated(), 'admin::components.impersonate')
</body>

</html>
