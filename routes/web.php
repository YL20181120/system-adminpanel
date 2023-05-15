<?php

use Admin\Http\Controllers;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;


Route::prefix(config('admin.prefix', 'admin'))->name('admin.')
    ->middleware([
        'web',
        'admin'
    ])
    ->group(function (Router $router) {

        $router->redirect('/', url(config('admin.prefix') . '/index.html'));

        $router->get('central/impersonate/{token}', function ($token) {
            return UserImpersonation::makeResponse($token);
        })->name('central.impersonate');

        $router->get('captcha/{config?}', [Controllers\CaptchaController::class, 'captcha'])->name('captcha');
        $router->get('index.html', [Controllers\IndexController::class, 'index'])->name('index');
        $router->match(['get', 'post'], 'index/theme.html', [Controllers\IndexController::class, 'theme'])->name('theme');
        $router->match(['get', 'post'], 'index/userinfo.html', [Controllers\IndexController::class, 'userinfo'])->name('userinfo');
        $router->match(['get', 'post'], 'index/password.html', [Controllers\IndexController::class, 'password'])->name('password');
        $router->match(['get', 'post'], 'index/two-factor-auth.html', [Controllers\IndexController::class, 'twoFactorAuth'])->name('two-factor-auth');
        // Sessions
        $router->get('sessions', [Controllers\SessionController::class, 'sessions'])->name('sessions');
        $router->delete('sessions/other-browser-sessions', [Controllers\SessionController::class, 'destroy'])->name('session.destroy');

        // 用户 Api 登录接口
        $router->group(['prefix' => 'auth'], function (Router $router) {
            $router->get('me', [Controllers\AuthController::class, 'me'])->name('auth.me');
        });

        // ApiToken
        $router->get('api_tokens', [Controllers\ApiTokenController::class, 'index'])->name('api-token.index');
        $router->getOrPost('api_tokens/create', [Controllers\ApiTokenController::class, 'create'])->name('api-token.create');
        $router->delete('api_tokens', [Controllers\ApiTokenController::class, 'destroy'])->name('api-token.destroy');
        $router->getOrPost('api_tokens/{token}/permissions', [Controllers\ApiTokenController::class, 'permissions'])->name('api-token.permissions');

        $router->group(['prefix' => 'api'], function (Router $router) {
            $router->get('plugs/script', [Controllers\api\PlugsController::class, 'script'])->name('plugs.script');
            $router->get('plugs/icon', [Controllers\api\PlugsController::class, 'icon'])->name('plugs.icon');
            $router->get('upload/index.js', [Controllers\api\UploadController::class, 'index'])->name('upload.index');
            $router->post('upload/state', [Controllers\api\UploadController::class, 'state'])->name('upload.state');
            $router->post('upload/file', [Controllers\api\UploadController::class, 'file'])->name('upload.file');
            $router->post('upload/done', [Controllers\api\UploadController::class, 'done'])->name('upload.done');
            $router->get('upload/image', [Controllers\api\UploadController::class, 'image'])->name('upload.image');

            $router->post('admin/editor', [Controllers\api\SystemController::class, 'editor'])->name('admin.editor');
        });

        $router->get('role', [Controllers\RoleController::class, 'index'])->name('role.index');
        $router->delete('role/destroy', [Controllers\RoleController::class, 'destroy'])->name('role.destroy');

        $router->get('role/create', [Controllers\RoleController::class, 'createOrUpdate'])->name('role.create');
        $router->post('role', [Controllers\RoleController::class, 'createOrUpdate'])->name('role.store');
        $router->get('role/{role}', [Controllers\RoleController::class, 'createOrUpdate'])->name('role.edit');
        $router->post('role/{role}', [Controllers\RoleController::class, 'createOrUpdate'])->name('role.update');
        $router->getOrPost('role/{role}/apply', [Controllers\RoleController::class, 'apply'])->name('role.apply');


        $router->admin('permission', Controllers\PermissionController::class);


        $router->match(['get', 'post'], 'menu', [Controllers\MenuController::class, 'index'])->name('menu.index');
        $router->delete('menu/destroy', [Controllers\MenuController::class, 'destroy'])->name('menu.destroy');
        $router->post('menu/state', [Controllers\MenuController::class, 'state'])->name('menu.state');

        $router->get('menu/create', [Controllers\MenuController::class, 'createOrUpdate'])->name('menu.create');
        $router->post('menu/store', [Controllers\MenuController::class, 'createOrUpdate'])->name('menu.store');
        $router->get('menu/{menu}', [Controllers\MenuController::class, 'createOrUpdate'])->name('menu.edit');
        $router->post('menu/{menu}', [Controllers\MenuController::class, 'createOrUpdate'])->name('menu.update');

        $router->get('user', [Controllers\UserController::class, 'index'])->name('user.index');
        $router->post('user/state', [Controllers\UserController::class, 'state'])->name('user.state');
        $router->delete('user/destroy', [Controllers\UserController::class, 'destroy'])->name('user.destroy');
        $router->match(['get', 'post'], 'user/{user}/password', [Controllers\UserController::class, 'password'])->name('user.password');
        $router->match(['get', 'post'], 'user/create', [Controllers\UserController::class, 'create'])->name('user.create');
        $router->match(['get', 'post'], 'user/{user}/edit', [Controllers\UserController::class, 'edit'])->name('user.edit');

        $router->get('dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');

        // Config
        $router->get('config/index', [Controllers\ConfigController::class, 'index'])->name('config.index');
        $router->getOrPost('config/storage', [Controllers\ConfigController::class, 'storage'])->name('config.storage');
        $router->getOrPost('config/admin', [Controllers\ConfigController::class, 'admin'])->name('config.admin');

        // File
        $router->get('files', [Controllers\FileController::class, 'index'])->name('files');
        $router->getOrPost('file/{file}/update', [Controllers\FileController::class, 'update'])->name('file.update');
        $router->delete('file/{file}', [Controllers\FileController::class, 'destroy'])->name('file.destroy');
        $router->post('files/distinct', [Controllers\FileController::class, 'distinct'])->name('file.distinct');

        $router->get('logs', [Controllers\LogController::class, 'index'])->name('log.index');
        $router->delete('logs/destroy', [Controllers\LogController::class, 'destroy'])->name('log.destroy');
        $router->get('log/{log}', [Controllers\LogController::class, 'show'])->name('log.show');

        $router->impersonate();
    });

