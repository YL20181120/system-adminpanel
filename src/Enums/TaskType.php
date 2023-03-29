<?php

namespace System\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self whats_app_contact_check()
 */
final class TaskType extends Enum
{
    protected static function labels()
    {
        return [
            'whats_app_contact_check' => 'What\'s app 空号检测'
        ];
    }
}
