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
    protected static $DB = 0;

    protected static $call = '';

    public static $command = '';

    protected static $selected = '';

    public static function lPush($key,$value,$db = 0)
    {
        self::selectDb($db);
        Redis::lpush($key,$value);
    }

    public static function call($call,...$param)
    {
        self::selectDb();  // 没有指定数据库 则使用默认的数据库
        if(empty($param)){
            $param[] = 0; // 设定参数个数为0
        }
        call_user_func_array([Redis::class,'eval'],array_merge([$call],$param));
    }

    /**
     * Select the db which you want to operate.
     *
     * @param $db
     */
    public static function selectDb($db = 0)
    {
        self::$DB = $db;
        Redis::select(self::$DB);
    }

}