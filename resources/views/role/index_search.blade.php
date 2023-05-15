<x-admin::table.search>
    <x-admin::table.search.select :options="['admin' => 'admin', 'user' => 'User']" label="Guard" name="guard_name"
                                   placeholder="Please choose guard for search"/>
    <x-admin::table.search.date :range="false" name="created_at"/>
</x-admin::table.search>
