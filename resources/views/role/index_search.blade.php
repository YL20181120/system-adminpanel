<x-system::table.search>
    <x-system::table.search.select :options="['system' => 'System']" label="Guard" name="guard_name"
                                   placeholder="Please choose guard for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
