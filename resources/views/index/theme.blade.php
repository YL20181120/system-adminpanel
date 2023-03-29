<form action="{{ request()->url() }}" method="post" data-auto="true" class="layui-form layui-card" id="theme">
    <div class="layui-card-body padding-left-40">

        <div class="layui-form-item margin-bottom-5 label-required-prev">
            <div class="help-label"><b>后台配色方案</b>Theme Style</div>
            <div class="layui-textarea think-bg-gray" style="min-height:unset">
                @foreach($themes as $k => $v)
                    <label class="think-radio">
                        <input name="theme" type="radio" value="{{$k}}" lay-ignore @checked($model->theme == $k)> {{$v}}
                    </label>
                @endforeach
            </div>
            <p class="help-block">切换配色方案，需要保存成功后配色方案才会永久生效，下次登录也会有效哦 ~</p>
        </div>
    </div>

    <div class="hr-line-dashed"></div>
    <div class="layui-form-item text-center">
        <button class="layui-btn" type="submit">保存配置</button>
        <button class="layui-btn layui-btn-danger" type='button' data-close>取消修改</button>
    </div>
</form>

<script>
    $('form#theme input[name=theme]').on('click', function () {
        var alls = '', that = this, prox = 'layui-layout-theme-', curt = prox + that.value;
        $('form#theme input[name=theme]').map(function () {
            if (this.value !== that.value) alls += ' ' + prox + this.value;
        });
        $('.layui-layout-body').removeClass(alls).addClass(curt)
    });
</script>
