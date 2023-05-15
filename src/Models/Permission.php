<?php

namespace Admin\Models;

use Spatie\Permission\Models\Permission as BasePermission;
use Admin\Traits\HasDatetimeFormatter;

class Permission extends BasePermission
{
    use HasDatetimeFormatter;
}
