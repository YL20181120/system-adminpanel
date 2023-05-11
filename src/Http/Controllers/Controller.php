<?php

namespace System\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use System\Models\User;
use System\Traits\WithHttpResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use WithHttpResponse;

    public array $except = [];

    public array $exceptPermissions = [];

    public function __construct()
    {
        $this->middleware(['auth:system'])->except($this->except);
    }

    public function user(): User
    {
        return auth('system')->user();
    }
}
