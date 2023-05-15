<?php /** @var \Laravel\Sanctum\PersonalAccessToken $model */ ?>
<x-admin::form table-id="menu"
                :action="request()->url()">
    <x-admin::form.checkbox label="Permissions" :required="true"
                             :options="\Admin\Http\Controllers\ApiTokenController::$permissionsMap"
                             name="permissions"
                             :value="$model->abilities"
    ></x-admin::form.checkbox>
</x-admin::form>
