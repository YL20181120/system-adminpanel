<x-system::form :action="request()->url()" table-id="UserTable">

    <x-system::form.input :value="$model->email" name="email" :disabled="true">
        <x-slot:label><b>登录用户账号</b>Email</x-slot:label>
    </x-system::form.input>

    <x-system::form.input type="password" name="current_password" pattern="^\S{1,}$" required vali-name="验证密码"
                          placeholder="请输入旧的登录密码">
        <x-slot:label><b>旧的登录密码</b>Old Password</x-slot:label>
        <x-slot:help>
            请输入旧密码来验证修改权限，旧密码不限制格式。
        </x-slot:help>
    </x-system::form.input>

    <x-system::form.input type="password" name="password" pattern="^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$).{8,32}$"
                          :required="true"
                          vali-name="登录密码"
                          placeholder="请输入新的登录密码">
        <x-slot:label><b>新的登录密码</b>Password</x-slot:label>
        <x-slot:help>
            密码必须包含大小写字母、数字、符号的任意两者组合。
        </x-slot:help>
    </x-system::form.input>
    <x-system::form.input type="password" name="password_confirmation"
                          pattern="^(?![\d]+$)(?![a-zA-Z]+$)(?![^\da-zA-Z]+$).{8,32}$"
                          :required="true" vali-name="验证密码"
                          placeholder="请输入旧的登录密码">
        <x-slot:label><b>重复登录密码</b>Password Confirmation</x-slot:label>
        <x-slot:help>
            密码必须包含大小写字母、数字、符号的任意两者组合。
        </x-slot:help>
    </x-system::form.input>

</x-system::form>
