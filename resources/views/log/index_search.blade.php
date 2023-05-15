<x-admin::table.search :fieldset="false">
    <x-admin::table.search.input label="UserName" name="username"
                                  placeholder="Please type username for search"/>
    <x-admin::table.search.date :range="false" name="created_at"/>
</x-admin::table.search>
