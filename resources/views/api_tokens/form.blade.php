<x-admin::form table-id="menu"
                :action="route('admin.api-token.create')" data-callable="showMsg">
    <x-admin::form.input label="Name" name="name" :required="true"
                          placeholder="Please input name">
    </x-admin::form.input>

    <x-admin::form.checkbox label="Permissions" :required="true"
                             :options="\Admin\Http\Controllers\ApiTokenController::$permissionsMap"
                             name="permissions"
    ></x-admin::form.checkbox>

    <x-slot:script>
        <script>
            function showMsg(ret) {
                if (ret.flash.token) {
                    $.msg.closeLastModal();
                    tmp = `
<div>Please copy your new API token. For your security, it won't be shown again.</div>
                    <div class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 break-all">${ret.flash.token}</div>
                    `
                    $.msg.confirm(tmp, function () {
                        $.form.reload();
                    })
                    return false;
                }
            }
        </script>
    </x-slot:script>
</x-admin::form>
