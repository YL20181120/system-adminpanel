<?php /** @var \System\Models\Worker $model */ ?>
<x-system::form table-id="WorkerTable"
                :action="$model->exists ? route('system.worker.update', $model): route('system.worker.store')">

    <x-system::form.input label="Username" name="username" :required="true"
                          placeholder="Please input username" :value="$model->username"></x-system::form.input>
    <x-system::form.input label="Description" name="description"
                          placeholder="Please input description"></x-system::form.input>
</x-system::form>
