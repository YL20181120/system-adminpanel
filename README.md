* 生成前端路由 `php artisan ziggy:generate`
* 编译资源 `npm run build`
* 生成接口文档 `php artisan l5:gen`

```json
{
    "config": {
        ...
        "gitlab-domains": [
            "git.aixuexue.net"
        ],
        "gitlab-token": {
            "git.aixuexue.net": "qarUBhL7EsgASpr8Nnbx"
        },
        "secure-http": false
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "http://git.aixuexue.net/cash-bus/system-adminpanel.git"
        }
    ]
}
```

```shell
composer require jasmine/adminpanel_2023:"^1.0"
```

```shell
composer update jasmine/adminpanel_2023:"^1.0"
```

tailwind.config.js content 添加下面的

```
'./vendor/jasmine/adminpanel_2023/resources/views/**/*.blade.php'
```
