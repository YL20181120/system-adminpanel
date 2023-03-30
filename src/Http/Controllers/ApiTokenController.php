<?php

namespace System\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Laravel\Sanctum\PersonalAccessToken;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use System\Traits\WithDataTableResponse;

class ApiTokenController extends Controller
{
    use WithDataTableResponse;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        return $this->page('system::api_tokens.index', builder: $this->user()->tokens());
    }

    protected function _index_page_filter(&$data, $ext)
    {
        foreach ($data as $token) {
            $token->last_used_ago = optional($token->last_used_at)->diffForHumans();
            $token->abilities_str = join(',', $token->abilities);
        }
    }

    static array $permissions
        = [
            'create',
            'read',
            'update',
            'delete',
        ];
    static array $permissionsMap
        = [
            'create' => 'create',
            'read'   => 'read',
            'update' => 'update',
            'delete' => 'delete',
        ];

    public static function validPermissions(array $permissions)
    {
        return array_values(array_intersect($permissions, static::$permissions));
    }

    public function create(Request $request)
    {
        if ($request->isPost()) {
            $request->validate([
                'name'          => ['required', 'string', 'max:255'],
                'permissions'   => ['required', 'array'],
                'permissions.*' => [Rule::in(self::$permissions)]
            ]);

            $token = $request->user()->createToken(
                $request->name,
                self::validPermissions($request->input('permissions', []))
            );

            $this->success('success', flash: [
                'token' => explode('|', $token->plainTextToken, 2)[1],
            ]);
        }
        return view('system::api_tokens.form');
    }

    public function destroy(Request $request)
    {
        $this->batchDestroy($request->user()->tokens());
    }

    public function permissions(PersonalAccessToken $token)
    {
        if (\request()->isPost()) {
            $token->forceFill([
                'abilities' => self::validPermissions(request()->input('permissions', [])),
            ])->save();
            $this->success('Updated.');
        }
        return $this->form('system::api_tokens.permissions', $token);
    }
}
