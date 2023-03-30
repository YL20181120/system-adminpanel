<?php

namespace System\Traits;


use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait WithDataTableResponse
{
    public array $__sharded = [];

    protected function sendData(LengthAwarePaginator|Collection|array $data, ...$args): void
    {
        if (is_array($data)) {
            $count = count($data);
        }
        if ($data instanceof Collection) {
            $count = $data->count();
        }
        if ($data instanceof LengthAwarePaginator) {
            $count = $data->total();
            $data = $data->items();
        }

        $this->callback('_page_filter', $data, $args);

        throw new HttpResponseException(response()->json([
            'code'  => 0,
            'data'  => $data,
            'msg'   => 'success',
            'count' => $count ?? 0
        ]));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function page($view, Builder $builder, $page = true, $data = [])
    {
        if (request()->isMethod('post')) {
            $this->_sort($builder);
        }

        if ($this->shouldJson()) {
            if ($sort = $this->shouldSort()) {
                $builder->orderByRaw(sprintf('%s %s', $sort['field'], $sort['order']));
            }
            match ($page) {
                true => $_data = $builder->paginate($this->getPerPageLimit()),
                false => $_data = $builder->get()
            };
            $this->sendData($_data, ...$data);
        }

        $this->page = $page;
        $this->assignProperties();
        return view($view, $data);
    }

    protected function _sort(Builder $builder)
    {
        switch (strtolower(request()->post('action', ''))) {
            case 'sort':
                request()->validate([]);
                $builder->where('id', request('id'))->update([request('field') => request(request('field'))]);
                $this->success('Sort updated.', '');
            default:
                break;
        };
    }


    protected function assignProperties(): void
    {
        foreach ($this->__sharded as $key => $val) {
            View::share($key, $val);
        }
    }

    /**
     * @param string $view
     * @param Model $model
     * @param $data
     * @param $fillable
     * @param $validators
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function form($view, Model $model, $data = [], $fillable = [], $validators = [])
    {
        if (request()->isMethod('get')) {
            if (false !== $this->callback('_form_filter', $model)) {
                $this->assignProperties();
                return view($view, array_merge($data, ['model' => $model]));
            }
        }

        if (in_array(strtolower(request()->method()), ['post', 'put', 'patch'])) {
            if (!blank($validators)) {
                request()->validate($validators);
            }
            $data = array_merge(request()->except('spm', '_method'), $data);
            if (false !== $this->callback('_form_filter', $model, $data, $fillable)) {
                $model->exists ? $model->update(Arr::only($data, $fillable)) : $model::create(Arr::only($data, $fillable));
                if (false !== $this->callback('_form_result', $result, $model)) {
                    if ($result !== false) {
                        $this->success(__('恭喜, 数据保存成功'), '');
                    }
                    $this->error(__('数据保存失败, 请稍候再试'));
                }
            }
        }
    }

    public function batchDestroy(Builder|Model $builder, $where = []): void
    {
        $ids = $this->getBatchIds();
        if ($builder instanceof Model) {
            $builder = $builder::query();
        }
        foreach ($builder->whereIn('id', $ids)
                     ->where($where)
                     ->select(['id'])
                     ->cursor() as $item) {
            $item->delete();
        };
        $this->success('删除成功', '');
    }

    public function batchUpdate(Model $model, $data, $where = []): void
    {
        $ids = $this->getBatchIds();
        foreach ($model::query()->whereIn('id', $ids)
                     ->where($where)
                     ->select(['id'])
                     ->cursor() as $item) {
            $item->update($data);
        };
        $this->success('更新成功', '');
    }

    public function __set(string $name, $value): void
    {
        if (!property_exists($this, $name)) {
            $this->__sharded[$name] = $value;
        }
    }

    /**
     * 数据回调处理机制
     * @param string $name 回调方法名称
     * @param mixed $one 回调引用参数1
     * @param mixed $two 回调引用参数2
     * @param mixed $thr 回调引用参数3
     * @return boolean
     */
    public function callback(string $name, &$one = [], &$two = [], &$thr = []): bool
    {
        if (is_callable($name)) return call_user_func($name, $this, $one, $two, $thr);
        $action = request()->route()->getActionMethod();
        foreach (["_{$action}{$name}", $name] as $method) {
            if (method_exists($this, $method) && false === $this->$method($one, $two, $thr)) {
                return false;
            }
        }
        return true;
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function shouldJson(): bool
    {
        $output = request()->get('output', 'view');
        return $output === 'layui.table';
    }

    protected function shouldSort(): bool|array
    {
        if (request()->has('_order_') && request()->has('_field_')) {
            return ['field' => request('_field_'), 'order' => request('_order_')];
        }
        return false;
    }

    protected int $limit = 20;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getPerPageLimit(): int
    {
        return min(100, request()->get('limit', $this->limit));
    }

    protected function getBatchIds($field = 'id')
    {
        return array_filter(Arr::wrap(explode(',', request()->post($field, ''))));
    }
}
