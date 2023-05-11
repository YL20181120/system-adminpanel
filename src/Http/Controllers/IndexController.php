<?php

namespace System\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use System\Models\User;
use System\Services\SystemMenuService;
use System\Traits\WithAuthUser;
use System\Traits\WithDataTableResponse;

class IndexController extends Controller
{
    use WithDataTableResponse;
    use WithAuthUser;

    public function index()
    {
        $menus = SystemMenuService::getTree();
        View::share('menus', $menus);
        return view('system::index.index');
    }

    public function theme()
    {
        return $this->form('system::index.theme', auth()->user(), [
            'themes' => ConfigController::themes
        ], fillable: ['theme']);
    }

    public function userinfo()
    {
        return $this->form('system::index.userinfo', $this->user(), fillable: ['username', 'phone', 'description', 'lang', 'headimg'],
            validators: [
                'username'    => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
                'description' => ['nullable', 'string', 'max:255'],
            ]);
    }

    /**
     * @param $result
     * @param User $model
     * @return void
     */
    protected function _userinfo_form_result($result, $model)
    {
        if ($model->wasChanged('lang')) {
            $this->success(__('system::system.update_success'), 'javascript:location.reload()');
        }
    }


    public function password()
    {
        return $this->form('system::index.password', $this->user());
    }

    public function twoFactorAuth()
    {
        if (Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm') &&
            is_null($this->user()->two_factor_confirmed_at)) {
            app(DisableTwoFactorAuthentication::class)(Auth::user());
        }
        return $this->form('system::index.two-factor-authentication-form', $this->user());
    }
}
