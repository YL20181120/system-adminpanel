<?php

namespace System\Traits;


use System\Models\User;

trait WithAuthUser
{
    public function user(): User
    {
        return auth('system')->user();
    }
}
