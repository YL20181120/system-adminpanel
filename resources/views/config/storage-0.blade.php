<div class="layui-form-item">
    <label class="layui-form-label label-required">
        <b class="color-green">命名方式</b><br><span class="nowrap color-desc">NameType</span>
    </label>
    <div class="layui-input-block">
        @foreach(['xmd5'=>'文件哈希值 ( 支持秒传 )','date'=>'日期+随机 ( 普通上传 )'] as $k=>$v)
            <label class="think-radio notselect">
                <input @checked(sysconf('storage.name_type') == $k) type="radio" name="storage.name_type" value="{{$k}}"
                       lay-ignore> {{$v}}
            </label>
        @endforeach
        <p class="help-block">类型为“文件哈希”时可以实现文件秒传功能，同一个文件只需上传一次节省存储空间，推荐使用。</p>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label label-required">
        <b class="color-green">链接类型</b><br><span class="nowrap color-desc">LinkType</span>
    </label>
    <div class="layui-input-block">
        @foreach(['none'=>'简洁链接','full'=>'完整链接','none+compress'=>'简洁并压缩图片','full+compress'=>'完整并压缩图片'] as $k=>$v)
            <label class="think-radio notselect">
                <input @checked(sysconf('storage.link_type') == $k) type="radio" name="storage.link_type" value="{{$k}}"
                       lay-ignore> {{$v}}
            </label>
        @endforeach
        <p class="help-block">类型为“简洁链接”时链接将只返回 hash
            地址，而“完整链接”将携带参数保留文件名，图片压缩功能云平台会单独收费。</p>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label" for="storage.allow_exts">
        <b class="color-green">允许类型</b><br><span class="nowrap color-desc">AllowExts</span>
    </label>
    <div class="layui-input-block">
        <input id="storage.allow_exts" type="text" name="storage.allow_exts" value="{{sysconf('storage.allow_exts')}}"
               required vali-name="文件后缀" placeholder="请输入系统文件上传后缀" class="layui-input">
        <p class="help-block">设置系统允许上传文件的后缀，多个以英文逗号隔开如：png,jpg,rar,doc，未设置允许上传的后缀</p>
    </div>
</div>
