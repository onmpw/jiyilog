<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/8
 * Time: 10:14
 */
namespace Onmpw\JiyiLog\Ext;

use Illuminate\Support\Facades\Redis;

class RedisDB
{
    public static $DB = 0;

    public static function lPush($key,$value)
    {
        Redis::select(self::$DB);
        Redis::lpush($key,$value);
    }

}