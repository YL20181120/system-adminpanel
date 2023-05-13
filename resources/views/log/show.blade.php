<?php
/** @var \System\Models\Log $model */
?>
<div class="p-4">
    <table class="layui-table">
        <tbody>
        <tr>
            <th>Path</th>
            <td>{{ $model->uri }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $model->username }}</td>
        </tr>
        <tr>
            <th>Method</th>
            <td>{{ $model->method }}</td>
        </tr>
        <tr>
            <th>User Agent</th>
            <td>{{ $model->user_agent }}</td>
        </tr>
        <tr>
            <th>IP</th>
            <td>{{ $model->geoip }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $model->created_at }}</td>
        </tr>
        <tr>
            <th>Request</th>
            <td>
                <pre class="layui-code request"
                     lay-skin="notepad">{{ json_encode($model->request, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
            </td>
        </tr>
        <tr>
            <th>Response</th>
            <td>
                <pre
                    class="layui-code response"
                    lay-skin="notepad">{{ json_encode($model->response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    $(function () {
        layui.use('code', function () {
            layui.code({
                title: 'Request',
                elem: '.request'
            })
            layui.code({
                title: 'Response',
                elem: '.response',
                height: '300px'
            })
        })
    });
</script>
