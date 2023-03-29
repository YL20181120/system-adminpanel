<?php

namespace System\Services;

use System\Models\Menu;

class SystemMenuService
{
    public static function getList()
    {

    }

    public static function getTree(): array
    {
        $menus = Menu::query()->where(['status' => 1])->orderByRaw('sort desc, id asc')->get()->toArray();
        return static::filter(TreeService::arr2tree($menus));
    }

    private static function filter(array $menus): array
    {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = static::filter($menu['sub']);
            }
            if (!empty($menu['sub'])) {
                $menu['url'] = '#';
                // todo 角色菜单控制
//            } elseif (empty($menu['url']) || $menu['url'] === '#' || !(empty($menu['node']) || AdminService::check($menu['node']))) {
            } elseif (empty($menu['url']) || $menu['url'] === '#' || !(empty($menu['node']) || true)) {
                unset($menus[$key]);
            } elseif (preg_match('#^(https?:)?//\w+#i', $menu['url'])) {
                if ($menu['params']) $menu['url'] .= (strpos($menu['url'], '?') === false ? '?' : '&') . $menu['params'];
            } else {
                $node = join('/', array_slice(str2arr($menu['url'], '/'), 0, 3));
                $menu['url'] = url('/system/index.html#/' . $menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
//                if (!AdminService::check($node)) unset($menus[$key]);
            }
        }
        return $menus;
    }
}
