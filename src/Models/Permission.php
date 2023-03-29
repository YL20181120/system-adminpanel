<?php

namespace System\Models;

use Spatie\Permission\Models\Permission as BasePermission;
use System\Traits\HasDatetimeFormatter;

class Permission extends BasePermission
{
    use HasDatetimeFormatter;
}
