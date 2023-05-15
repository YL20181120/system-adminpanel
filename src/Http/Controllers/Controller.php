<?php

namespace Admin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Admin\Models\User;
use Admin\Traits\WithHttpResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    use WithHttpResponse;

    public array $except = [];

    public array $exceptPermissions = [];

    public function __construct()
    {
        $this->middleware(['auth:admin'])->except($this->except);
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return auth('admin')->user();
    }
}
