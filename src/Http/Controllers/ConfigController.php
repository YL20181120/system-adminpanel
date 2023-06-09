<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use Admin\Traits\WithDataTableResponse;

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
        return view('admin::config.index');
    }

    /**
     * 系统配置
     */
    public function admin(Request $request)
    {
        if ($request->isGet()) {
            return view('admin::config.admin', ['themes' => self::themes]);
        } else {
            $post = $request->post();
            foreach ($post as $k => $v) sysconf($k, $v);
            $this->success('修改系统参数成功！', 'javascript:window.location.reload()');
        }
    }

    public function storage(Request $request)
    {
        if ($request->isGet()) {
            $type = $request->input('type', 'local');
            return view('admin::config.storage-' . $type);
        } else {
            $post = $request->post();
            if (!empty($post['storage']['allow_exts'])) {
                $deny = ['sh', 'asp', 'bat', 'cmd', 'exe', 'php'];
                $exts = array_unique(str2arr(strtolower($post['storage']['allow_exts'])));
                if (count(array_intersect($deny, $exts)) > 0) $this->error('禁止上传可执行的文件！');
                $post['storage']['allow_exts'] = join(',', $exts);
            }
            foreach ($post as $name => $value) sysconf($name, $value);
            $this->success('修改文件存储成功！');
        }
    }
}
