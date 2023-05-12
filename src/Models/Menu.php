<?php

namespace System\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\TenantConnection;

class Menu extends Model
{
    use HasRoles;

    use TenantConnection;

    protected $table = 'system_menu';

    protected $guarded = ['id'];

    protected string $guard_name = 'system';

    protected $attributes
        = [
            'params' => ''
        ];

    use Translatable;

    public array $translatedAttributes = ['title'];
}
