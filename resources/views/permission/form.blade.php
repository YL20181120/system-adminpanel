<x-admin::form table-id="role"
                :action="$model->exists ? route('admin.permission.update', $model): route('admin.permission.store')">
    <x-admin::form.select :options="['admin' => 'admin', 'user' => 'User']" name="guard_name" label="Guard Name"
                           :value="$model->guard_name"/>
    <x-admin::form.input label="Name" name="name" :value="$model->name" id="permission-name"/>

    <script>
        require(['jquery.autocompleter'], function () {
            $('#permission-name').autocompleter({
                limit: 5,
                source: (function (subjects, data) {
                    for (var i in subjects) data.push({value: subjects[i], label: subjects[i]});
                    return data;
                })(@json(\Admin\Admin::nodes()), [])
            })
        });
    </script>

</x-admin::form>
