<?php

namespace System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use System\Traits\HasDatetimeFormatter;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable, TwoFactorAuthenticatable;
    use HasRoles;
    use HasDatetimeFormatter;
    use SoftDeletes;

    protected $table = 'system_users';

    protected $fillable = ['email', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'username', 'phone', 'last_login_at', 'last_login_ip', 'ban_at', 'description', 'theme'];

    protected $hidden
        = [
            'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'
        ];

    protected $dates
        = [
            'email_verified_at', 'two_factor_confirmed_at', 'ban_at', 'last_login_at'
        ];


    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
