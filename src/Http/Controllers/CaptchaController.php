<?php

namespace Admin\Http\Controllers;


use Mews\Captcha\Captcha;

class CaptchaController extends Controller
{
    public array $exceptPermissions = ['captcha'];

    public array $except
        = [
            'captcha'
        ];

    public function captcha(Captcha $captcha, $config = 'default')
    {
        $image = $captcha->create($config, true);
        $this->success('Captcha created', [
            'image'  => $image['img'],
            'uniqid' => $image['key'],
            'code'   => uniqid()
        ]);
    }
}
