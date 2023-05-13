<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Model;
use System\Models\Traits\HasUser;
use System\Traits\HasDatetimeFormatter;

class Log extends Model
{
    protected $table = 'system_logs';

    protected $fillable = ['uri', 'user_id', 'user_agent', 'username', 'geoip', 'request', 'response', 'method'];

    use HasUser, HasDatetimeFormatter;

    protected $casts
        = [
            'request'  => 'array',
            'response' => 'array'
        ];
}
