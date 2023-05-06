<?php
/** @var \Lab404\Impersonate\Services\ImpersonateManager $app */
$app = app('impersonate');
$impersonator = $app->getImpersonator();
?>

<div
    style="position:fixed; width: 100vw; height: 36px; background: rgba(255, 0, 0, .6);z-index: 99999999999;bottom: 0;
    display: flex; align-items: center; color: white; font-size: 14px; font-weight: 600;padding: 0 30px; justify-content: space-between">
    <div>
        You <span style="color: yellowgreen;font-weight: 800;font-size: 18px">[{{ $impersonator->username }}]</span> are
        impersonate
        with
        user <span style="color: yellowgreen;font-weight: 800;font-size: 18px">{{ auth()->user()->username }}</span>
    </div>
    <div>
        <a data-href="{{ route('system.impersonate.leave') }}" style="color: white">Click to Stop Impersonate</a>
    </div>
</div>
<style>

</style>
