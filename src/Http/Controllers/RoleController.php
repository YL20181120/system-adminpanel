<?php

namespace System\Http\Controllers;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use System\Models\Role;
use System\Traits\WithDataTableResponse;

class RoleController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Role $role)
    {
        return $this->page('system::role.index', builder: $role::query()
            ->searchEqual('guard_name')
            ->searchDate('created_at')
        );
    }

    public function destroy(Role $role)
    {
        $this->batchDestroy($role);
    }

    public function createOrUpdate(Role $role)
    {
        return $this->form(
            'system::role.form',
            $role, [],
            ['guard_name', 'name'],
            [
                'guard_name' => 'required|in:system,user',
                'name'       => 'required|max:255'
            ]);
    }
}
