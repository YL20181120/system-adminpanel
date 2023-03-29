<x-system::form table-id="role"
                :action="route('system.tasks.store')">
    <?php /** @var \System\Models\Task $model */ ?>

    <x-system::form.select :options="\System\Enums\TaskType::toArray()" name="type" label="任务类型"
                           :value="$model->type"/>

    <x-system::form.input-file label="附件" name="attachment">
        <x-slot:help>
            <p><a href="{{ asset('templates/contacts-template.xlsx') }}">What's app 空号检测 模板下载</a></p>
        </x-slot:help>
    </x-system::form.input-file>

    <x-system::form.input name="remark" label="备注" :required="true"></x-system::form.input>
</x-system::form>
