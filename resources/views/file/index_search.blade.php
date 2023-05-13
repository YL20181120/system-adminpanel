<x-system::table.search :fieldset="false">
    <x-system::table.search.input label="Name" name="name"
                                  placeholder="Please type name for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
