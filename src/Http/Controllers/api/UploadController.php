<?php

namespace System\Http\Controllers\api;


use Illuminate\Http\Request;
use System\Helpers\Storage;
use System\Http\Controllers\Controller;
use System\Models\File;

class UploadController extends Controller
{
    public function index()
    {
        $data = ['exts' => []];
        foreach (str2arr(sysconf('storage.allow_exts|raw')) as $ext) {
            $data['exts'][$ext] = Storage::mime($ext);
        }
        return response(view('system::api.upload-js', $data)->render())->header('Content-Type', 'application/x-javascript');
    }

    public function state(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'hash' => 'required',
            'xext' => 'required',
            'size' => 'required',
        ]);
        $data = [
            'type'    => 'local',
            'safe'    => intval($this->getSafe()),
            'xkey'    => $request->post('key'),
            'user_id' => auth()->id(),
            'name'    => $request->post('name'),
            'hash'    => $request->post('hash'),
            'xext'    => $request->post('xext'),
            'size'    => $request->post('size'),
            'mime'    => $request->post('mime', Storage::mime($request->post('xext'))),
            'xurl'    => \Illuminate\Support\Facades\Storage::disk('public')->url($request->post('key'))
        ];

        $file = File::query()->firstOrCreate($request->only('hash'), $data);
        if ($file->wasRecentlyCreated || $file->status === 1) {
            $this->success('获取上传授权参数', [
                'uptype' => 'local',
                'safe'   => $this->getSafe(),
                'key'    => $request->post('key'),
                'id'     => $file->id,
                'server' => route('system.upload.file', absolute: false),
                'url'    => $file->xurl
            ], 404);
        } else {
            $file = $file->replicate(['user_id']);
            $file->user_id = auth()->id();
            $file->push();
            $this->success('文件已上传', [
                'uptype' => 'local',
                'safe'   => $this->getSafe(),
                'key'    => $request->post('key'),
                'id'     => $file->id,
                'url'    => $file->xurl
            ], 200);
        }
    }

    public function file(Request $request)
    {
        $file = $request->file('file');
        $safeMode = $this->getSafe();
        $extension = strtolower($file->getClientOriginalExtension());
        $saveName = $request->post('key');
        if (strpos($saveName, '../') !== false) {
            $this->error('文件路径不能出现跳级操作！');
        }
        // 检查文件后缀是否被恶意修改
        if (strtolower(pathinfo(parse_url($saveName, PHP_URL_PATH), PATHINFO_EXTENSION)) !== $extension) {
            $this->error('文件后缀异常，请重新上传文件！');
        }
        // 屏蔽禁止上传指定后缀的文件
        if (!in_array($extension, str2arr(sysconf('storage.allow_exts|raw')))) {
            $this->error('文件类型受限，请在后台配置规则！');
        }
        if (in_array($extension, ['sh', 'asp', 'bat', 'cmd', 'exe', 'php'])) {
            $this->error('文件安全保护，禁止上传可执行文件！');
        }
        $name = explode('/', $saveName);
        if ($file->storeAs($name[0], $name[1], 'public')) {
            $this->success('文件上传成功！', ['url' => $safeMode ? $saveName : \Illuminate\Support\Facades\Storage::disk('public')->url($saveName)]);
        } else {
            $this->error('文件保存失败');
        }
    }

    public function done(Request $request)
    {
        $request->validate([
            'id'   => 'required',
            'hash' => 'required',
        ]);

        $file = File::query()->find($request->post('id'));
        if ($file->exists()) {
            $file->update(['status' => 2]);
            $this->success('更新成功!');
        } else {
            $this->error('更新失败!');
        }
    }

    private function getSafe()
    {
        return boolval(request('safe', 0));
    }

}
