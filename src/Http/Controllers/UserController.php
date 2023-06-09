<?php

namespace Admin\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Admin\Actions\Fortify\ResetUserPassword;
use Admin\Actions\Fortify\UpdateUserProfileInformation;
use Admin\Models\User;
use Admin\Traits\WithDataTableResponse;

class UserController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(User $user)
    {
        $type = request()->get('type', 'index');
        return $this->page('admin::user.index', builder: $user::query()
            ->searchDate('created_at')
            ->searchLike('email')
            ->when($type === 'index', function ($q) {
                $q->whereNull('ban_at');
            })
            ->when($type === 'recycle', function ($q) {
                $q->whereNotNull('ban_at');
            }), data: ['type' => $type]);
    }

    public function create(User $user, CreatesNewUsers $creator, Request $request)
    {
        if (\request()->isMethod('post')) {
            /** @var User $user */
            $user = $creator->create($request->only('email', 'phone', 'username', 'description', 'headimg'));
            $roles = \request('roles', []);
            $user->syncRoles($roles);
            $this->success('Created.', '');
        }
        return $this->form('admin::user.form', $user);
    }

    public function edit(User $user, UpdateUserProfileInformation $updater, Request $request)
    {
        if (\request()->isMethod('post')) {
            $updater->update($user, $request->only('email', 'phone', 'username', 'description', 'headimg'));
            $roles = \request('roles', []);
            $user->syncRoles($roles);
            $this->success('Updated.', '');
        }
        return $this->form('admin::user.form', $user);
    }

    /**
     * 重置用户密码
     * @param User $user
     * @param UpdatesUserPasswords $reseter
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void|null
     */
    public function password(User $user, ResetUserPassword $reset, Request $request)
    {
        if (\request()->isMethod('post')) {
            $reset->reset($user, $request->only('password', 'password_confirmation'));
            $this->success('Password reset success.', '');
        }
        return $this->form('admin::user.password', $user);
    }


    public function destroy(User $user)
    {
        $this->batchDestroy($user);
    }


    public function state(Request $request)
    {
        $ids = $this->getBatchIds();
        $status = intval($request->post('status', 0)) === 0 ? now() : null;
        foreach (User::query()->whereIn('id', $ids)->cursor() as $user) {
            $user->update(['ban_at' => $status]);
        }
        $this->success('State Updated.');
    }
}
