<x-system::form table-id="role"
                :action="$model->exists ? route('system.role.update', $model): route('system.role.store')">
    <x-system::form.select :options="['system' => 'System', 'user' => 'User']" name="guard_name" label="Guard Name"
                           :value="$model->guard_name"/>
    <x-system::form.translation-input label="Name" name="name" :model="$model"/>
</x-system::form>
