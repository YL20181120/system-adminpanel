<?php

namespace Admin\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Menu extends Model
{
    use HasRoles;

    protected $table = 'system_menu';

    protected $guarded = ['id'];

    protected string $guard_name = 'admin';

    protected $attributes
        = [
            'params' => ''
        ];

    use Translatable;

    public array $translatedAttributes = ['title'];
}
