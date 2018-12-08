<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 16:38
 */

namespace Onmpw\JiyiLog\Lib;

use Onmpw\JiyiLog\Ext\RedisDB;
use Onmpw\JiyiLog\Scripts\LuaScripts as Lua;

class RedisStore extends StoreBase implements StoreContract
{
    public function __construct(){
        parent::__construct();
    }

    public function store()
    {
        // 解析要存储的数据
        $this->parseData();

        parent::_store();
    }

    /**
     * Build your own data format
     */
    protected static function build()
    {
        $key = self::$data['api'];
        $value = json_encode([
            'access_time'=>date("Y-m-d H:i:s",self::$data['time']),
            'client_ip'=>self::$data['ip'],
            'access_param'=>self::$data['param']
        ]);

        // 获取当天的时间
        $today = date("Ymd",self::$data['time']);

        return ['key'=>$key,'value'=>$value,'today'=>$today];
    }

    /**
     * Store data into redis
     *
     * @param $data
     * @return bool
     */
    protected static function handle($data)
    {
        /**
         * 第一个参数表示 key的个数
         * 第二个参数为 要存放的redis 库 选择 0
         * 其余为参数
         */
        RedisDB::call(Lua::storeLogEval(),1,0,$data['key'],$data['value'],$data['today']);
        return true;
    }
}