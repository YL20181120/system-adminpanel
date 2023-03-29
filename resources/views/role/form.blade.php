<x-system::form table-id="role"
                :action="$model->exists ? route('system.role.update', $model): route('system.role.store')">
    <x-system::form.select :options="['system' => 'System', 'user' => 'User']" name="guard_name" label="Guard Name"
                           :value="$model->guard_name"/>

    <x-system::form.input label="Name" name="name" :required="true"
                          placeholder="Please input role name" :value="$model->name"></x-system::form.input>
</x-system::form>
