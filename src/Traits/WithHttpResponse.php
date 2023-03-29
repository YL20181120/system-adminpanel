<?php

namespace System\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

trait WithHttpResponse
{
    /**
     * 返回失败的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回代码
     */
    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') $data = new stdClass();
        throw new HttpResponseException(response()->json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    /**
     * 返回成功的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param mixed $code 返回代码
     */
    public function success($info, $data = '{-null-}', $code = 1): void
    {
        if ($data === '{-null-}') $data = new stdClass();
        $result = ['code' => $code, 'info' => $info, 'data' => $data];
        throw new HttpResponseException(response()->json($result));
    }

    /**
     * URL重定向
     * @param string $url 跳转链接
     * @param integer $code 跳转代码
     */
    public function redirect(string $url, int $code = 301): void
    {
        throw new HttpResponseException(redirect($url, $code));
    }
}
