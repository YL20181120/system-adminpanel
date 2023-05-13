<x-system::form table-id="RoleTable">
    <x-system::form.input label="Name" vali-name="File name" :value="$model->name"
                          :required="true"></x-system::form.input>
    <x-system::form.input label="Size" :disabled="true" :value="format_bytes($model->size)"></x-system::form.input>
    <x-system::form.input label="Hash" :disabled="true" :value="$model->hash"></x-system::form.input>
    <x-system::form.input label="Url" :disabled="true" :value="$model->xurl"></x-system::form.input>
</x-system::form>
