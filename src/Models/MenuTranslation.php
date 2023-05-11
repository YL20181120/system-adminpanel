<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class
MenuTranslation extends Model
{
    protected $table = 'system_menu_translations';

    public $timestamps = false;

    protected $fillable = ['title'];
}
