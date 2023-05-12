<?php

namespace System\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use System\Traits\HasDatetimeFormatter;

class User extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable;
    use HasRoles;
    use HasDatetimeFormatter;
    use SoftDeletes;

    use HasApiTokens;

    use Impersonate;

    protected $table = 'system_users';

    public string $guard_name = 'system';

    protected $fillable = ['email', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'username', 'phone', 'last_login_at', 'last_login_ip', 'ban_at', 'description', 'theme', 'lang', 'headimg'];

    protected $hidden
        = [
            'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'
        ];

    protected $dates
        = [
            'email_verified_at', 'two_factor_confirmed_at', 'ban_at', 'last_login_at'
        ];

    protected $appends = ['email_mask', 'phone_mask'];

    public function getEmailMaskAttribute(): string
    {
        return Str::mask($this->attributes['email'], '*', 3, 4);
    }

    public function getPhoneMaskAttribute(): string
    {
        return Str::mask($this->attributes['phone'], '*', 3, 4);
    }


    public function getSanctumToken($name = 'login'): string
    {
        return $this->createToken($name)->plainTextToken;
    }

    public function destroyCurrentSanctumTokens()
    {
        return $this->currentAccessToken()->delete();
    }

    /**
     * ToDo 增加角色权限时增加
     * @return true
     */
    public function canImpersonate()
    {
        return true;
    }

    public function canBeImpersonated()
    {
        return true;
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole('Administrator');
    }
}
