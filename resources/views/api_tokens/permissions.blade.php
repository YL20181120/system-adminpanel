<?php /** @var \Laravel\Sanctum\PersonalAccessToken $model */ ?>
<x-system::form table-id="menu"
                :action="request()->url()">
    <x-system::form.checkbox label="Permissions" :required="true"
                             :options="\System\Http\Controllers\ApiTokenController::$permissionsMap"
                             name="permissions"
                             :value="$model->abilities"
    ></x-system::form.checkbox>
</x-system::form>
