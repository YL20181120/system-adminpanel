<?php

namespace System\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use Laravel\Fortify\Actions\ConfirmPassword;
use System\Traits\WithAuthUser;
use System\Traits\WithDataTableResponse;

class SessionController extends Controller
{
    use WithDataTableResponse;
    use WithAuthUser;

    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            $data = collect();
        } else {
            $data = collect(
                DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $this->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
            )->map(function ($session) use ($request) {
                $agent = $this->createAgent($session);

                return (object)[
                    'agent'             => [
                        'is_desktop' => $agent->isDesktop(),
                        'platform'   => $agent->platform(),
                        'browser'    => $agent->browser(),
                    ],
                    'ip_address'        => $session->ip_address,
                    'is_current_device' => $session->id === $request->session()->getId(),
                    'last_active'       => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                ];
            });
        }
        return view('system::session.sessions', ['data' => $data]);
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }


    /**
     * Log out from other browser sessions.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthenticationException
     */
    public function destroy(Request $request, StatefulGuard $guard)
    {
        $confirmed = app(ConfirmPassword::class)(
            $guard, $request->user(), md5(md5($request->password))
        );

        if (!$confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        $guard->logoutOtherDevices(md5(md5($request->password)));

        $this->deleteOtherSessionRecords($request);

        $this->success('success');
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
