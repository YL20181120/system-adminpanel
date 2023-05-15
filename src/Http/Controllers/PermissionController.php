<?php

namespace Admin\Http\Controllers;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Admin\Models\Permission;
use Admin\Traits\WithDataTableResponse;

class PermissionController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Permission $permission)
    {
        return $this->page('admin::permission.index', builder: $permission::query()
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
            'admin::permission.form',
            $permission, [],
            ['guard_name', 'name'],
            [
                'guard_name' => 'required|in:admin,user',
                'name'       => 'required|string|max:255'
            ]
        );
    }
}
