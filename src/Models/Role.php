<?php

namespace System\Models;

use Spatie\Permission\Models\Role as BaseRole;
use System\Traits\HasDatetimeFormatter;

class Role extends BaseRole
{
    use HasDatetimeFormatter;
}
