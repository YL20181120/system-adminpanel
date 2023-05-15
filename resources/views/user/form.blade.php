<?php
/**
 * @var \admin\Models\User $model
 */
?>
<x-admin::form table-id="UserTable">
    <div class="padding-left-40">
        <fieldset class="layui-bg-gray">
            <legend><b class="layui-badge think-bg-violet">用户账号</b></legend>
            <div class="layui-row layui-col-space15">
                <div class="layui-col-xs2 text-center padding-top-15">
                    <input type="hidden" data-cut-width="500" data-cut-height="500" data-max-width="500"
                           data-max-height="500" name="headimg" value="{{ $model->headimg ?? '' }}">
                    <script>$('[name=headimg]').uploadOneImage();</script>
                </div>
                <div class="layui-col-xs5">
                    <label class="block relative" x-data="{edit: {{ $model->exists ? 1 : 0 }}}"
                           x-on:dblclick="edit=0">
                        <span class="help-label"><b>用户邮箱</b>User Email</span>
                        <input type="email" x-bind:disabled="edit===1" value='{{ $model->email ?? '' }}' required
                               vali-name="登录账号"
                               name="email"
                               placeholder="请输入登录账号"
                               class="layui-input"
                               x-bind:class="{'think-bg-gray': edit===1}"
                        <span class="help-block" x-html="edit">登录邮箱创建后不能再次修改.</span>
                    </label>
                </div>
                <div class="layui-col-xs5">
                    <label class="block relative">
                        <span class="help-label"><b>用户名称</b>User Name</span>
                        <input name="username" value='{{ $model->username }}' required vali-name="用户名称"
                               placeholder="请输入用户名称" class="layui-input">
                        <span class="help-block">用于区分用户数据的用户名称，请尽量不要重复.</span>
                    </label>
                </div>
            </div>
        </fieldset>
        <fieldset class="layui-bg-gray">
            <legend><b class="layui-badge think-bg-violet">用户资料</b></legend>
            <label class="layui-form-item block relative margin-top-10">
                <span class="help-label"><b>联系手机</b>Contact Mobile</span>
                <input type="tel" maxlength="32" name="phone" value='{{ $model->phone }}'
                       vali-name="联系手机" placeholder="请输入用户联系手机"
                       class="layui-input">
                <span class="color-desc">可选，请填写用户常用的联系手机号</span>
            </label>

            <label class="layui-form-item block relative margin-top-10">
                <span class="help-label"><b>用户描述</b>User Remark</span>
                <textarea placeholder="请输入用户描述" class="layui-textarea"
                          name="description">{{ $model->description }}</textarea>
            </label>
        </fieldset>
        <fieldset class="layui-bg-gray">
            <legend><b class="layui-badge think-bg-violet">用户权限</b></legend>
            <label class="layui-form-item block relative margin-top-10">
                <span class="help-label"><b>角色</b>Role</span>
                <div class="layui-textarea help-checks">
                    @foreach(\admin\Models\Role::query()->where('guard_name', 'admin')->pluck('name', 'id') as $k => $v)
                        <label class="think-checkbox">
                            <input type="checkbox" @checked($model->hasRole($k)) name="roles[]" value="{{ $k }}"
                                   lay-ignore>{{ $v }}
                        </label>
                    @endforeach
                </div>
            </label>
        </fieldset>
    </div>
</x-admin::form>
