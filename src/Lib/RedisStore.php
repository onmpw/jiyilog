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
     * Get days by the rangeDay from today
     * @param $rangeDay
     * @return array
     */
    public function getDays($rangeDay)
    {
        $day = date("Ymd");
        $days = [$day];
        for($index = 1;$index < $rangeDay;$index++){
            $passDayNum = 0-$index;
            $days[] = date('Ymd',strtotime("$passDayNum day",strtotime($day)));
        }
        return $days;
    }

    /**
     * Get the specified day's api
     * @param $day
     * @return array
     */
    public function getApiByDay($day)
    {
        $api = RedisDB::call(Lua::getApiByDay(),1,0,$day,-100,-1);

        //parse api format
        $apiInfo = [];
        while(!empty($api)){
            $apiInfo[array_shift($api)] = ['access_time'=>array_shift($api)];
        }

        // 按照 access_time 降序排序  目前是升序的
        $apiInfo = array_reverse($apiInfo);
        return $apiInfo;
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

        return [$key,$value,$today];
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
        return RedisDB::call(Lua::storeLogEval(),1,0,$data[0],$data[1],$data[2]);
    }
}