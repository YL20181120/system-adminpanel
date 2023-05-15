<x-admin::form table-id="RoleTable">
    <x-admin::form.input label="Name" vali-name="File name" :value="$model->name"
                          :required="true"></x-admin::form.input>
    <x-admin::form.input label="Size" :disabled="true" :value="format_bytes($model->size)"></x-admin::form.input>
    <x-admin::form.input label="Hash" :disabled="true" :value="$model->hash"></x-admin::form.input>
    <x-admin::form.input label="Url" :disabled="true" :value="$model->xurl"></x-admin::form.input>
</x-admin::form>
