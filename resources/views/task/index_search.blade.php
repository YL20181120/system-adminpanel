<x-system::table.search>
    <x-system::table.search.select :options="\System\Enums\TaskType::toArray()" label="任务类型" name="type"
                                   placeholder="Please choose guard for search"/>
    <x-system::table.search.select :options="\System\Enums\TaskStatus::toArray()" label="任务状态" name="status"
                                   placeholder="Please choose guard for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
