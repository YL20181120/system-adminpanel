<?php

namespace System\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self init()
 * @method static self running()
 * @method static self finished()
 * @method static self error()
 */
final class TaskStatus extends Enum
{
    protected static function values()
    {
        return [
            'error'    => -1,
            'init'     => 0,
            'running'  => 1,
            'finished' => 2,
        ];
    }

    protected static function labels()
    {
        return [
            'init'     => '未开始',
            'running'  => '正在运行',
            'finished' => '已完成',
            'error'    => '发生错误'
        ];
    }
}
