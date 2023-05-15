<?php
/**
 * @var \App\Models\User $model
 */
?>
<x-admin::form :action="request()->url()" table-id="UserTable">

    <x-admin::form.input :value="$model->email" name="email" :disabled="true">
        <x-slot:label><b>登录用户账号</b>Email</x-slot:label>
    </x-admin::form.input>

    {{--    {{ $model->two }}--}}
</x-admin::form>
