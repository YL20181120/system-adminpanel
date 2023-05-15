<?php

namespace Admin\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    protected $table = 'roles_translations';

    public $timestamps = false;

    protected $fillable = ['name'];
}
