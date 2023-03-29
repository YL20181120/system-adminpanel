<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Menu extends Model
{
    use HasRoles;

    protected $table = 'system_menu';

    protected $guarded = ['id'];

    protected $guard_name = 'system';

    protected $attributes
        = [
            'params' => ''
        ];
}
