<x-admin::form table-id="role"
                :action="$model->exists ? route('admin.role.update', $model): route('admin.role.store')">
    <x-admin::form.select :options="['admin' => 'admin', 'user' => 'User']" name="guard_name" label="Guard Name"
                           :value="$model->guard_name"/>
    <x-admin::form.translation-input label="Name" name="name" :model="$model"/>
</x-admin::form>
