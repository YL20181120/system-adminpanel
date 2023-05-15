<?php

namespace Admin\Http\Controllers;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\Permission\PermissionRegistrar;
use Admin\Models\Permission;
use Admin\Models\Role;
use Admin\Services\TreeService;
use Admin\Traits\WithDataTableResponse;

class RoleController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Role $role)
    {
        return $this->page('admin::role.index', builder: $role::query()
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
            'admin::role.form',
            $role, [],
            ['guard_name', 'name', ...config('translatable.locales')],
            array_merge([
                'guard_name' => 'required|in:admin,user',
            ], RuleFactory::make([
                '%name%' => 'required|string|max:255',
            ]))
        );
    }

    protected function _form_filter(Role $role, &$data)
    {
        if (\request()->isPost()) {
            $data['name'] = $role->fill($data)->translate('en')?->name;
        }
    }

    protected function _form_result($result, Role $model)
    {
        \Spatie\Permission\Models\Role::where(['id' => $model->id])->update(['name' => $model->translate($model->getDefaultLocale())?->name]);
    }

    public function apply(Request $request, Role $role)
    {
        if ($request->isPost()) {
            $action = $request->input('action', 'get');
            if ($action === 'get') {
                $this->success('', $this->createTree($role));
            }
            if ($action === 'save') {
                $request->validate([
                    'nodes' => 'array'
                ]);
                $role->syncPermissions($this->rejectNotExistPermission($request->input('nodes')));
                $this->success(__('权限授权更新成功'), '');
            }
        }

        return view('admin::role.apply', ['role' => $role]);
    }

    protected function rejectNotExistPermission($permissions)
    {
        return collect($permissions)->reject(function ($permission) {
            return !Permission::whereGuardName('admin')->whereName($permission)->exists();
        });
    }

    protected function createTree(Role $role)
    {
        $role->loadMissing('permissions');
        [$nodes, $pnodes] = [[], []];
        $permisssions = app(PermissionRegistrar::class)->getPermissions()->where('guard_name', 'admin')->pluck('name', 'id');
        foreach ($permisssions as $id => $node) {

            $count = substr_count($node, '/');
            $pnode = substr($node, 0, strripos($node, '/'));
            if ($count >= 4) {
                $pnode = substr($pnode, 0, strripos($pnode, '/'));
            }
            if ($count > 0) {
                in_array($pnode, $pnodes) or array_push($pnodes, $pnode);
                $nodes[$node] = ['node' => $node, 'title' => $node, 'pnode' => $pnode, 'checked' => $role->hasPermissionTo($node)];
            }
        }
        //补充父级node
        foreach ($pnodes as $key => $node) {
            if (isset($nodes[$node])) {
                continue;
            }
            $pnode = substr($node, 0, strripos($node, '/'));
            $nodes[$node] = ['node' => $node, 'title' => ucfirst($node), 'pnode' => $pnode, 'checked' => false];
        }
        return TreeService::arr2tree($nodes, 'node', 'pnode', '_sub_');
    }
}
