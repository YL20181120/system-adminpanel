<?php

namespace System\Http\Controllers;


use Astrotomic\Translatable\Validation\RuleFactory;
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
            ['guard_name', 'name', ...config('translatable.locales')],
            array_merge([
                'guard_name' => 'required|in:system,user',
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
}
