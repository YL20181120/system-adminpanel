<?php

namespace System\Services;

use System\Models\Menu;
use System\Models\User;

class SystemMenuService
{
    public static function getList()
    {

    }

    public static function getTree(): array
    {
        $menus = Menu::query()->where(['status' => 1])->orderByRaw('sort desc, id asc')
            ->with('roles')
            ->get()->toArray();
        return static::filter(TreeService::arr2tree($menus));
    }

    private static function filter(array $menus): array
    {
        /** @var User $user */
        $user = auth('system')->user();
        foreach ($menus as $key => &$menu) {
            $roles = array_column($menu['roles'], 'id');

            $unset = !$user->isAdministrator() && !$user->hasAnyRole($roles);

            if (!empty($menu['sub'])) {
                $menu['sub'] = static::filter($menu['sub']);
            }
            if (!empty($menu['sub'])) {
                $menu['url'] = '#';
            } elseif (empty($menu['url']) || $menu['url'] === '#' || !(empty($menu['node']) || $unset)) {
                unset($menus[$key]);
            } elseif (preg_match('#^(https?:)?//\w+#i', $menu['url'])) {
                if ($menu['params']) $menu['url'] .= (strpos($menu['url'], '?') === false ? '?' : '&') . $menu['params'];
            } else {
                $menu['url'] = url('/system/index.html#/' . $menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
                if ($unset) unset($menus[$key]);
            }
        }
        return $menus;
    }
}
