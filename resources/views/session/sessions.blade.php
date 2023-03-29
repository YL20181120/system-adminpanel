<div class="mt-5 md:mt-0">
    <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800">
        <div class=" text-sm text-gray-600 dark:text-gray-400">
            If necessary, you may log out of all of your other browser sessions across all of your devices. Some of
            your recent sessions are listed below; however, this list may not be exhaustive. If you feel your
            account has been compromised, you should also update your password.
        </div>

        <!-- Other Browser Sessions -->
        <div class="mt-5">
            @foreach($data as $session)
                <div class="flex items-center">
                    <div>
                        @if ($session->agent['is_desktop'])
                            <svg class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                            </svg>
                        @endif
                    </div>

                    <div class="ml-3">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $session->agent['platform'] ?: 'Unknown' }}
                            - {{ $session->agent['browser'] ?: 'Unknown' }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-green-500 font-semibold">This device</span>
                                @else
                                    <span>Last active {{ $session->last_active }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="flex items-center mt-5">
                <button type="button" onclick="logout()"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Log Out Other Browser Sessions
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        node = document.createElement('div')
        node.id = 'passwordForm'
        node.style.display = 'none'
        node.innerHTML = `
<form action="" method="post" data-auto="true" class="layui-form layui-card"
          >

        <div class="layui-card-body">
            <div class="layui-form-item">
    <label class="layui-form-label">Password</label>
    <div class="layui-input-block">
        <input type="password" name="password"
               required
        vali-name="Password"
               placeholder="Please input password"
            class="layui-input"
        >
    </div>
</div>
        </div>

        <div class="hr-line-dashed"></div>

        <div class="layui-form-item text-center">
            <button class="layui-btn" type='submit'>Confirm</button>
        <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>
Cancel
        </button>
        </div>
    </form>
        `
        document.body.appendChild(node)
    });

    function logout() {
        layer.open({
            type: 1,
            content: $('#passwordForm')
        })
        {{--layer.prompt({title: 'Password Confirm', formType: 1}, function (password, index) {--}}
        {{--    $.form.load('{{ route('system.session.destroy') }}', {--}}
        {{--        '_method': 'delete',--}}
        {{--        password: password--}}
        {{--    }, 'post');--}}
        {{--})--}}
    }
</script>
