<?php

use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use System\Services\SystemConfigService;

if (!function_exists('sysconf')) {
    function sysconf(string $name = '', $value = null, $default = null)
    {
        if (is_null($value) && is_string($name)) {
            return SystemConfigService::get($name, $default);
        } else {
            return SystemConfigService::set($name, $value);
        }
    }
}

if (!function_exists('str2arr')) {
    /**
     * 字符串转数组
     * @param string $text 待转内容
     * @param string $separ 分隔字符
     * @param ?array $allow 限定规则
     * @return array
     */
    function str2arr(string $text, string $separ = ',', ?array $allow = null): array
    {
        $items = [];
        foreach (explode($separ, trim($text, $separ)) as $item) {
            if ($item !== '' && (!is_array($allow) || in_array($item, $allow))) {
                $items[] = trim($item);
            }
        }
        return $items;
    }
}

if (!function_exists('arr2str')) {
    /**
     * 数组转字符串
     * @param array $data 待转数组
     * @param string $separ 分隔字符
     * @param ?array $allow 限定规则
     * @return string
     */
    function arr2str(array $data, string $separ = ',', ?array $allow = null): string
    {
        foreach ($data as $key => $item) {
            if ($item === '' || (is_array($allow) && !in_array($item, $allow))) {
                unset($data[$key]);
            }
        }
        return $separ . join($separ, $data) . $separ;
    }
}

if (!function_exists('system_route')) {
    function system_route($name, $parameters = [], $absolute = true): string
    {
        $url = app('url')->route($name, $parameters, $absolute);
        return urldecode($url);
    }
}



