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
                    <label class="block relative">
                        <span class="help-label"><b>用户邮箱</b>User Email</span>
                        <input type="email" disabled value='{{ $model->email ?? '' }}'
                               name="email"
                               class="layui-input think-bg-gray">
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
                <span class="help-label"><b>用户语言</b></span>
                <select name="lang">
                    @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <option
                            value="{{ $localeCode }}"
                            @selected($model->lang == $localeCode)>{{ $properties['native'] }}</option>
                    @endforeach
                </select>
            </label>
            <label class="layui-form-item block relative margin-top-10">
                <span class="help-label"><b>用户描述</b>User Remark</span>
                <textarea placeholder="请输入用户描述" class="layui-textarea"
                          name="description">{{ $model->description }}</textarea>
            </label>
        </fieldset>
    </div>
</x-admin::form>
