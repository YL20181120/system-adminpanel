<?php

namespace Admin\Http\Controllers;

use Flugg\Responder\Http\MakesResponses;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Admin\Models\User;

class AuthController extends Controller
{
    use MakesResponses;

    public array $except = ['login'];

    public function __construct()
    {
        $this->middleware('auth:admin-api')->except($this->except);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::query()->where('email', $request->request->get('username'))->firstOrFail();
        if (!Hash::check($request->request->get('password'), $user->password)) {
            return $this->error(400, 'password error')->respond(400);
        }

        if ($user->ban_at && $user->ban_at->lt(now())) {
            return $this->error(403, 'User baned at ' . $user->ban_at)->respond(403);
        }

        $user->last_login_at = now();
        $user->last_login_ip = $request->getClientIp();
        $user->push();
        return $this->success(['token' => $user->getSanctumToken()]);
    }

    public function me()
    {
        return $this->success(auth()->user());
    }

    public function logout()
    {
        auth('admin-api')->user()->destroyCurrentSanctumTokens();
        return $this->success('Logout successful.');
    }
}
