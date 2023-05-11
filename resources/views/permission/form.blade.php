<x-system::form table-id="role"
                :action="$model->exists ? route('system.permission.update', $model): route('system.permission.store')">
    <x-system::form.select :options="['system' => 'System', 'user' => 'User']" name="guard_name" label="Guard Name"
                           :value="$model->guard_name"/>
    <x-system::form.input label="Name" name="name" :value="$model->name" id="permission-name"/>

    <script>
        require(['jquery.autocompleter'], function () {
            $('#permission-name').autocompleter({
                limit: 5,
                source: (function (subjects, data) {
                    for (var i in subjects) data.push({value: subjects[i], label: subjects[i]});
                    return data;
                })(@json(\System\System::nodes()), [])
            })
        });
    </script>

</x-system::form>
