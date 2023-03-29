<?php

namespace System\Services;

use System\Models\Config;

class SystemConfigService
{
    private static $data = [];

    public static function get($name, string $default = '')
    {
        if (empty(static::$data)) {
            Config::cache()->map(function (Config $config) {
                static::$data[$config->type][$config->name] = $config->value;
            });
        }
        [$type, $field, $outer] = static::_parse($name);
        if (empty($name)) {
            return static::$data;
        } elseif (isset(static::$data[$type])) {
            $group = static::$data[$type];
            if ($outer !== 'raw') foreach ($group as $kk => $vo) {
                $group[$kk] = htmlspecialchars(strval($vo));
            }
            return $field ? ($group[$field] ?? $default) : $group;
        } else {
            return $default;
        }
    }

    public static function set($name, $value)
    {
        static::$data = [];
        [$type, $field] = static::_parse($name);
        if (is_array($value)) {
            $count = 0;
            foreach ($value as $kk => $vv) {
                $count += static::set("{$field}.{$kk}", $vv);
            }
            return $count;
        } else {
            $map = ['type' => $type, 'name' => $field];
            $data = array_merge($map, ['value' => $value]);
            $query = Config::query()->where($map);
            return $query->clone()->count() > 0 ? $query->update($data) : $query->insert($data);
        }
    }

    private static function _parse(string $rule): array
    {
        $type = 'base';
        if (stripos($rule, '.') !== false) {
            [$type, $rule] = explode('.', $rule, 2);
        }
        [$field, $outer] = explode('|', "{$rule}|");
        return [$type, $field, strtolower($outer)];
    }
}
