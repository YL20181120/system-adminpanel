<x-system::form :action="request()->url()" table-id="UserTable">

    <x-system::form.input :value="$model->username" name="email" :disabled="true">
        <x-slot:label><b>登录账号</b></x-slot:label>
    </x-system::form.input>

    <x-system::form.input type="password" name="password"
                          :required="true"
                          vali-name="登录密码"
                          placeholder="请输入新的登录密码">
        <x-slot:label><b>新的登录密码</b>Password</x-slot:label>
    </x-system::form.input>
    <x-system::form.input type="password" name="password_confirmation"
                          :required="true" vali-name="验证密码"
                          placeholder="请输入旧的登录密码">
        <x-slot:label><b>重复登录密码</b>Password Confirmation</x-slot:label>
    </x-system::form.input>

</x-system::form>
