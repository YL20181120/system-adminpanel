<?php

namespace System\Http\Controllers\api;


use Illuminate\Http\Request;
use System\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function editor(Request $request)
    {
        $editor = $request->input('editor', 'auto');
        sysconf('base.editor', $editor);
        $this->success('已切换后台编辑器！', 'javascript:location.reload()');
    }
}
