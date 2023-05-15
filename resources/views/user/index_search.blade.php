<x-admin::table.search :fieldset="false">
    <x-admin::table.search.input label="Email" name="email"
                                  placeholder="Please type email for search"/>
    <x-admin::table.search.date :range="false" name="created_at"/>
</x-admin::table.search>
