<?php
/**
 * @var \App\Models\User $model
 */
?>
<x-system::form :action="request()->url()" table-id="UserTable">

    <x-system::form.input :value="$model->email" name="email" :disabled="true">
        <x-slot:label><b>登录用户账号</b>Email</x-slot:label>
    </x-system::form.input>

    {{--    {{ $model->two }}--}}
</x-system::form>
