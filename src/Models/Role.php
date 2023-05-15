<?php

namespace Admin\Models;

use Astrotomic\Translatable\Translatable;
use Spatie\Permission\Models\Role as BaseRole;
use Admin\Traits\HasDatetimeFormatter;

class Role extends BaseRole
{
    use HasDatetimeFormatter;

    use Translatable;

    protected $fillable             = ['guard_name', 'name'];
    public    $translatedAttributes = ['name'];
}
