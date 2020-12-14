# jiyilog
记录项目中 api 访问日志，并可以通过web进行展示.
这个扩展是针对`laravel`使用的。

### 安装
使用`composer`进行安装
```
composer require onmpw/jiyilog
```
然后在 config/app.php 配置项`providers`中添加 `Onmpw\JiyiLog\JiyiLogServiceProvider`
```php
return [
'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Onmpw\JiyiLog\JiyiLogServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class
    ]
];
```

### 使用
使用也比较简单
```php
$api = "Your Api Name";
$parameters = []; // 访问参数

$log = new Onmpw\JiyiLog\JLog();

$log->log($api,$parameters);
```

默认情况下，日志是记录在了 Redis中，所以要在项目中配置Redis的访问。
同时，该扩展提供了将Redis中的数据备份到数据库的命令
```bash
# php artisan Log backup
```
数据库已经在 Migrations中创建好了，可以执行Laravel相关的 migrate命令创建数据库。

对于日志的访问，该扩展提供了两个模板，可以通过内置的路由进行访问
`yourdomain/showlog` 和 `yourdomain/viewlog`

