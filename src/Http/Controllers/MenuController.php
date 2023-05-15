<?php

namespace Admin\Http\Controllers;


use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Admin\Models\Menu;
use Admin\Services\TreeService;
use Admin\Traits\WithDataTableResponse;

class MenuController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Menu $menu)
    {
        return $this->page('admin::menu.index', builder: $menu::query()
            ->orderByRaw('sort desc, id asc'), page: false, data: ['type' => \request()->get('type', 'index')]);
    }

    protected function _index_page_filter(&$data, $ext)
    {
        $data = TreeService::arr2tree($data
            ->transform(function (Menu $menu) {
                $item = $menu->toArray();
                $item['title'] = $menu->translate(App::getLocale())?->title;
                return $item;
            })
            ->toArray());
        if ($ext['type'] === 'recycle') foreach ($data as $k1 => &$p1) {
            if (!empty($p1['sub'])) foreach ($p1['sub'] as $k2 => &$p2) {
                if (!empty($p2['sub'])) foreach ($p2['sub'] as $k3 => $p3) {
                    if ($p3['status'] > 0) unset($p2['sub'][$k3]);
                }
                if (empty($p2['sub']) && ($p2['url'] === '#' or $p2['status'] > 0)) unset($p1['sub'][$k2]);
            }
            if (empty($p1['sub']) && ($p1['url'] === '#' or $p1['status'] > 0)) unset($data[$k1]);
        }
        $data = TreeService::arr2table($data);
        foreach ($data as &$vo) {
            if ($vo['url'] !== '#' && !preg_match('/^(https?:)?(\/\/|\\\\)/i', $vo['url'])) {
                $vo['url'] = trim(url($vo['url']) . ($vo['params'] ? "?{$vo['params']}" : ''), '\\/');
            }
        }
    }

    public function destroy(Menu $menu)
    {
        $this->batchDestroy($menu);
    }

    /**
     * @param Menu $current_menu
     * @return void
     */
    protected function _form_filter(&$current_menu)
    {
        if (request()->isGet()) {
            $menus = TreeService::arr2table(array_merge(Menu::all()->toArray(), [['id' => '0', 'pid' => '-1', 'url' => '#', 'title' => '顶部菜单']]));
            $data = [];
            foreach ($menus as $menu) {
                if ($menu['spt'] >= 3 || $menu['url'] !== '#') {
                    continue;
                }
                $data[$menu['id']] = sprintf("%s%s", $menu['spl'], $menu['title']);
            }
            $this->menus = $data;
            $current_menu->pid = \request('pid', $current_menu->pid);
        }

        if (request()->isPost()) {
            $roles = \request('roles', []);
            $current_menu->syncRoles($roles);
        }
    }

    public function createOrUpdate(Request $request, Menu $menu)
    {
        return $this->form(
            'admin::menu.form',
            $menu,
            [],
            ['title', 'url', 'params', 'icon', 'pid', ...config('translatable.locales')],
            array_merge(
                [
                    'url'    => 'required|max:400',
                    'params' => 'nullable|max:500'
                ],
                RuleFactory::make([
                    '%title%' => 'required|string|max:255',
                ])
            )
        );
    }

    public function state(Request $request)
    {
        $ids = $this->getBatchIds();
        Menu::query()->whereIn('id', $ids)->update(['status' => $request->status]);
        $this->success('');
    }
}
