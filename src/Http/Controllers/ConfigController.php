<?php

namespace System\Http\Controllers;

use System\Traits\WithDataTableResponse;

class ConfigController extends Controller
{
    use WithDataTableResponse;

    const themes
        = [
            'default' => '默认色0',
            'white'   => '简约白0',
            'red-1'   => '玫瑰红1',
            'blue-1'  => '深空蓝1',
            'green-1' => '小草绿1',
            'black-1' => '经典黑1',
            'red-2'   => '玫瑰红2',
            'blue-2'  => '深空蓝2',
            'green-2' => '小草绿2',
            'black-2' => '经典黑2',
        ];

    public function index()
    {
        return view('system::config.index');
    }
}
