<x-admin::table.search :fieldset="false">
    <x-admin::table.search.input label="Name" name="name"
                                  placeholder="Please type name for search"/>
    <x-admin::table.search.date :range="false" name="created_at"/>
</x-admin::table.search>
