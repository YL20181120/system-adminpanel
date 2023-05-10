<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\TenantConnection;

class Menu extends Model
{
    use HasRoles;

    use TenantConnection;

    protected $table = 'system_menu';

    protected $guarded = ['id'];

    protected $guard_name = 'system';

    protected $attributes
        = [
            'params' => ''
        ];
}
