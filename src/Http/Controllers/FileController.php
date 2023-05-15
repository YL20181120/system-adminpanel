<?php

namespace Admin\Http\Controllers;


use Illuminate\Database\Query\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Admin\Models\File;
use Admin\Traits\WithDataTableResponse;

class FileController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(File $file)
    {
        return $this->page('admin::file.index', builder: $file::query()
            ->searchLike('name')
            ->searchDate('created_at')
        );
    }

    public function destroy(File $file)
    {
        $this->batchDestroy($file, select: ['xkey']);
    }

    /**
     * 清理重复文件
     * @return void
     */
    public function distinct()
    {
        File::query()->whereNotIn('id', function (Builder $q) {
            return $q->selectRaw('id')
                ->fromSub(function (Builder $q) {
                    return $q->from(with(new File)->getTable())
                        ->selectRaw('max(id) as id')
                        ->groupByRaw('type,xkey');
                }, 'dt');
        })->delete();
        File::query()->where(['status' => 1])->delete();
        $this->success('Clean Done.', '');
    }

    public function update(File $file)
    {
        return $this->form(
            'admin::file.form',
            $file, [],
            ['name'],
            [
                'name' => 'required|string|max:255',
            ]
        );
    }
}
