<?php

namespace System\Http\Controllers\api;


use Illuminate\Http\Request;
use System\Http\Controllers\Controller;

class PlugsController extends Controller
{
    public array $except
        = [
            'script',
            'icon'
        ];

    public function script()
    {
        // 这里和图片上传, 图标选择有关系
        return response(join("\r\n", [
            sprintf("window.taAdmin = '%s';", '/' . config('system.prefix')),
            sprintf("window.taEditor = '%s';", sysconf('base.editor|raw') ?: 'ckeditor4'),
            sprintf("window.lang = '%s';", app()->getLocale() ?: 'en'),
        ]))->header('Content-Type', 'application/x-javascript');
    }

    public function icon(Request $request)
    {
        return view('system::api.plugs.icon', [
            'title' => '图标选择器',
            'field' => $request->get('field', 'icon')
        ]);
    }
}
