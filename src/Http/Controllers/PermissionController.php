<?php

namespace System\Http\Controllers;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use System\Models\Permission;
use System\Traits\WithDataTableResponse;

class PermissionController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Permission $permission)
    {
        return $this->page('system::permission.index', builder: $permission::query()
            ->searchEqual('guard_name')
            ->searchDate('created_at')
        );
    }

    public function destroy(Permission $permission)
    {
        $this->batchDestroy($permission);
    }

    public function createOrUpdate(Permission $permission)
    {
        return $this->form(
            'system::permission.form',
            $permission, [],
            ['guard_name', 'name'],
            [
                'guard_name' => 'required|in:system,user',
                'name'       => 'required|string|max:255'
            ]
        );
    }
}
