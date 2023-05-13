<?php

namespace System\Services;

use Illuminate\Support\Facades\App;
use System\Models\Menu;
use System\Models\User;

class SystemMenuService
{
    public static function getTree(): array
    {
        $menus = Menu::query()
            ->where(['status' => 1])
            ->orderByRaw('sort desc, id asc')
            ->with('roles', 'translations')
            ->get()
            ->transform(function (Menu $menu) {
                $item = $menu->toArray();
                $item['title'] = $menu->translate(App::getLocale())?->title;
                // 替换默认的路由前缀
                $item['url'] = preg_replace('/^system/', config('system.prefix'), $item['url']);
                return $item;
            });
        return static::filter(TreeService::arr2tree($menus->toArray()));
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
            } elseif (empty($menu['url']) || $menu['url'] === '#') {
                unset($menus[$key]);
            } elseif (preg_match('#^(https?:)?//\w+#i', $menu['url'])) {
                if ($menu['params']) $menu['url'] .= (!str_contains($menu['url'], '?') ? '?' : '&') . $menu['params'];
            } else {
                $menu['url'] = url(config('system.prefix') . '/index.html#/' . $menu['url']) . (empty($menu['params']) ? '' : "?{$menu['params']}");
                if ($unset) unset($menus[$key]);
            }
        }
        return $menus;
    }
}
