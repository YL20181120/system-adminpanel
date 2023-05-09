<?php

namespace System\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Config extends Model
{
    protected $table = 'system_config';

    protected static string $cache_key = 'system_config';


    protected $fillable = ['type', 'name', 'value'];

    public static function cache(): Collection
    {
        return Cache::rememberForever(self::$cache_key, function () {
            return static::query()->get();
        });
    }

    public static function refreshCache()
    {
        Cache::forget(self::$cache_key);
        static::cache();
    }
}
