<?php

namespace System\Listeners;

use Stancl\Tenancy\Events\TenancyInitialized;

/**
 * Class SetTimezone
 * @author Jasmine <youjingqiang@gmail.com>
 */
class SetTimezone
{
    public function handle(TenancyInitialized $event)
    {
        config(['app.timezone' => sysconf('base.timezone', default: 'UTC')]);
        date_default_timezone_set(sysconf('base.timezone', default: 'UTC'));
    }
}
