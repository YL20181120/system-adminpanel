<?php

namespace Admin;

use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Admin\Http\Middleware\SystemPermissionChecker;

/**
 * Class System
 * @package System
 * @author Jasmine <youjingqiang@gmail.com>
 */
class Admin
{
    public static function countries()
    {
        return require_once __DIR__ . "/Data/country.php";
    }

    public static function nodes()
    {
        $app = app();
        $routes = $app->routes->getRoutes();
        $path = [];
        $ignore = resolve(SystemPermissionChecker::class)->except;
        foreach ($routes as $k => $value) {
            /** @var Route $value */
            if (collect($ignore)->contains(fn($pattern) => Str::is($pattern, $value->uri)) || Str::startsWith($value->getName(), 'central')) {
                continue;
            }
            $path[$k] = $value->uri;
        }
        $path = array_values(array_unique($path));
        $temp_path = [];
        foreach ($path as $item) {
            $temp_path[] = preg_replace('/\{[\s\S]*?\}/i', '*', $item);
        }
        unset($path);
        return $temp_path;
    }

    public static function get_permission_from_component(ComponentAttributeBag|array $attributes = []): string|null
    {
        $url = collect(Arr::only($attributes->getAttributes(), ['data-modal', 'data-href', 'data-open', 'data-iframe', 'data-action']))->filter()->first();
        $info = parse_url($url);
        $path = trim($info['path'], '/');
        return $path === '' ? '/' : $path;
    }

    public static function check_system_permission($user, ComponentAttributeBag|array $attributes = [])
    {
        if (in_array(request()->getHost(), config('tenancy.central_domains', []))) {
            return true;
        }

        if ($user != null && method_exists($user, 'hasAnyRole') && $user->hasAnyRole('Administrator')) {
            return true;
        }

        if ($user != null) {
            $url = self::get_permission_from_component($attributes);
            $permissions = app(PermissionRegistrar::class)->getPermissions()->where('guard_name', 'admin');
            $permission = $permissions->first(function (Permission $permission) use ($url) {
                return Str::is($permission->name, $url);
            });
            if ($permission) {
                return $user->can($permission->name);
            }
        }

        return false;
    }
}
