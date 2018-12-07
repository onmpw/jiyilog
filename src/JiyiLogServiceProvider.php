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

class JiyiLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*$this->app->singleton(CryptContract::class,function ($app){
            return new MyCrypt();
        });*/
    }
}