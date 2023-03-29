<x-system::table.search>
    <x-system::table.search.input name="username" label="Username"
                                  placeholder="Please input username for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
