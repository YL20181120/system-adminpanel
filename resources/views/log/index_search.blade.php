<x-system::table.search :fieldset="false">
    <x-system::table.search.input label="UserName" name="username"
                                  placeholder="Please type username for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
