<?php

namespace System\Http\Controllers;


use Jenssegers\Agent\Agent;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use System\Models\Log;
use System\Traits\WithDataTableResponse;

class LogController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Log $log)
    {
        return $this->page('system::log.index', builder: $log::query()
            ->searchLike('username')
            ->searchDate('created_at')
        );
    }

    protected function _index_page_filter(&$data)
    {
        foreach ($data as &$vo) {
            $agent = tap(new Agent, function ($agent) use ($vo) {
                $agent->setUserAgent($vo->user_agent);
            });

            $vo['user_agent'] = [
                'is_desktop' => $agent->isDesktop(),
                'platform'   => $agent->platform(),
                'browser'    => $agent->browser(),
            ];
        }
    }

    public function destroy(Log $log)
    {
        $this->batchDestroy($log);
    }

    public function show(Log $log)
    {
        return $this->form('system::log.show', $log);
    }
}
