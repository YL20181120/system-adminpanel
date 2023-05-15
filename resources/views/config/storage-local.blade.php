<form action="{{ request()->url() }}" method="post" data-auto="true" class="layui-form layui-card">
    <div class="layui-card-body padding-top-20">

        <div class="color-text layui-code text-center layui-bg-gray" style="border-left-width:1px;margin:0 0 15px 40px">
            <p class="margin-bottom-5 font-w7">文件将存储在本地服务器，默认保存在 storage/app/public 目录，文件以 HASH
                命名。</p>
            <p>文件存储的目录需要有读写权限，有足够的存储空间。<span
                    class="color-red">特别注意，本地存储暂不支持图片压缩！</span></p>
        </div>

        @include('admin::config.storage-0')

        <div class="layui-form-item">
            <label class="layui-form-label label-required">
                <b class="color-green">访问协议</b><br><span class="nowrap color-desc">Protocol</span>
            </label>
            <div class="layui-input-block">
                @if (!sysconf('storage.local_http_protocol'))
                    @php
                        sysconf('storage.local_http_protocol', 'follow')
                    @endphp
                @endif

                @foreach(['follow'=>'FOLLOW','http'=>'HTTP','https'=>'HTTPS','path'=>'PATH','auto'=>'AUTO'] as $protocol=>$remark)
                    <label class="think-radio">
                        <input @checked(sysconf('storage.local_http_protocol') == $protocol) type="radio"
                               name="storage.local_http_protocol" value="{{$protocol}}" lay-ignore>
                        {{$remark}}
                    </label>
                @endforeach
                <p class="help-block">本地存储访问协议，其中 HTTPS 需要配置证书才能使用（ FOLLOW 跟随系统，PATH 文件路径，AUTO
                    相对协议 ）</p>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" for="storage.local_http_domain">
                <b class="color-green">访问域名</b><br><span class="nowrap color-desc">Domain</span>
            </label>
            <div class="layui-input-block">
                <input id="storage.local_http_domain" type="text" name="storage.local_http_domain"
                       value="{{ sysconf('storage.local_http_domain') }}" placeholder="请输入上传后的访问域名 (非必填项)"
                       class="layui-input">
                <p class="help-block">
                    填写上传后的访问域名（不指定时根据当前访问地址自动计算），如：static.thinkadmin.top</p>
            </div>
        </div>

        <div class="hr-line-dashed margin-left-40"></div>
        <input type="hidden" name="storage.type" value="local">

        <div class="layui-form-item text-center padding-left-40">
            <button class="layui-btn" type="submit">保存配置</button>
            <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消修改吗？" data-close>
                取消修改
            </button>
        </div>

    </div>
</form>
