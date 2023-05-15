<?php

namespace Admin\Helpers;

class Storage
{
    /**
     * 获取后缀类型
     * @param array|string $exts 文件后缀
     * @param array $mime 文件信息
     * @return string
     */
    public static function mime($exts, array $mime = []): string
    {
        $mimes = static::mimes();
        foreach (is_string($exts) ? explode(',', $exts) : $exts as $ext) {
            $mime[] = $mimes[strtolower($ext)] ?? 'application/octet-stream';
        }
        return join(',', array_unique($mime));
    }

    /**
     * 获取所有类型
     * @return array
     */
    public static function mimes(): array
    {
        static $mimes = [];
        if (count($mimes) > 0) return $mimes;
        return $mimes = include __DIR__ . '/mimes.php';
    }
}
