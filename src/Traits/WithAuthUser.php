<?php

namespace Admin\Traits;


use Admin\Models\User;

trait WithAuthUser
{
    public function user(): User
    {
        return auth('admin')->user();
    }
}
