<?php

use Admin\Models\User;

return [
    'prefix'      => env('ADMIN_PREFIX', 'admin'),
    'model'       => User::class,
    'middlewares' => []
];
