<x-system::table.search :fieldset="false">
    <x-system::table.search.input label="Email" name="email"
                                  placeholder="Please type email for search"/>
    <x-system::table.search.date :range="false" name="created_at"/>
</x-system::table.search>
