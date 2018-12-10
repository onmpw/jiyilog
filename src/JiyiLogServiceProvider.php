<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * HomePage: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 14:10
 */

namespace Onmpw\JiyiLog;

use Illuminate\Support\ServiceProvider;
use Onmpw\JiyiLog\Lib\StoreContract;
use Onmpw\JiyiLog\Lib\RedisStore;

class JiyiLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 加载视图
        $this->loadViewsFrom(__DIR__.'/Views','jiyilog');

        // 加载路由
        $this->loadRoutesFrom(__DIR__."/route.php");

        // 加载数据库Migration
        $this->loadMigrationsFrom(__DIR__."/Migrations");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StoreContract::class,function ($app){
            return $app->make(RedisStore::class);
        });
    }
}