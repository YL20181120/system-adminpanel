<x-admin::form table-id="menu"
                :action="$model->exists ? route('admin.menu.update', $model): route('admin.menu.store')">

    <x-admin::form.select :options="$menus" name="pid" label="上级菜单"
                           :value="$model->pid"/>

    <x-admin::form.translation-input label="菜单名称" name="title" :model="$model">
        <x-slot:help>
            <b>必选</b>，请填写菜单名称 ( 如：系统管理 )，建议字符不要太长，一般 4-6 个汉字
        </x-slot:help>
    </x-admin::form.translation-input>

    <x-admin::form.input label="菜单链接" name="url" :required="true"
                          placeholder="请输入菜单链接" :value="$model->url"
                          onblur="this.value=this.value === ''?'#':this.value">
        <x-slot:help>
            <b>必选</b>，请填写链接地址或选择系统节点 ( 如：https://domain.com/admin/user/index.html 或
            admin/user/index )
            <br>当填写链接地址时，以下面的 “权限节点” 来判断菜单自动隐藏或显示，注意未填写 “权限节点” 时将不会隐藏该菜单哦
        </x-slot:help>
    </x-admin::form.input>

    <x-admin::form.input label="链接参数" name="params"
                          placeholder="请输入链接参数" :value="$model->params">
        <x-slot:help>
            <b>可选</b>，设置菜单链接的 GET 访问参数 ( 如：name=1&age=3 )
        </x-slot:help>
    </x-admin::form.input>


    <div class="layui-form-item">
        <label class="layui-form-label">菜单图标</label>
        <div class="layui-input-block">
            <div class="layui-input-inline">
                <input placeholder="请输入或选择图标" name="icon" value='{{ $model->icon }}' class="layui-input">
            </div>
            <span style="padding:0 12px;min-width:45px" class='layui-btn layui-btn-primary'>
                    <i style="font-size:1.2em;margin:0;float:none" class='{{ $model->icon }}'></i>
                </span>
            <button data-icon='icon' type='button' class='layui-btn layui-btn-primary'>选择图标</button>
            <p class="help-block"><b>可选</b>，设置菜单选项前置图标，目前支持 layui 字体图标及 iconfont 定制字体图标。</p>
        </div>
    </div>

    <x-admin::form.checkbox label="Role"
                             :options="use System\Models\Role::query()->where('guard_name', 'admin')->pluck('name', 'id')"
                             name="roles"
                             :value="$model->roles->pluck('id')->toArray()"
    ></x-admin::form.checkbox>

    <x-slot:script>
        <script>
            require(['jquery.autocompleter'], function () {
                $('[name="icon"]').on('change', function () {
                    $(this).parent().next().find('i').get(0).className = this.value
                });
            });
        </script>
    </x-slot:script>
</x-admin::form>
