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
    const APITIMESETNAME = 'JIYILOG_API_TIME_SET';

    public function __construct(){
        parent::__construct();
    }

    /**
     * Store Api
     */
    public function store()
    {
        // Parses the data to be stored.
        $this->parseData();

        parent::_store();
    }

    /**
     * Get days by the rangeDay from today.
     *
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
     * Gets the api list for the specified date
     *
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

        // Sort in desc order of access_time,currently in ascending order.
        $apiInfo = array_reverse($apiInfo);
        return $apiInfo;
    }

    /**
     * Gets information about the specified Api
     *
     * @param $api
     * @return mixed
     */
    public function getApiInfo($api)
    {
        $infoList = RedisDB::call(Lua::getApiInfo(),1,0,$api,0,-1);

        // parse data
        $infoList = array_map(function($info){
            $info = json_decode($info,true);
            if(is_array($info['access_param'])){
                $info['access_param'] = json_encode($info['access_param']);
            }

            if(strlen($info['access_param']) > 150){
                $info['access_param_abstract'] = substr($info['access_param'],0,150)."...";
                $info['stack'] = true;
            }else{
                $info['access_param_abstract'] = $info['access_param'];
                $info['stack'] = false;
            }

            return $info;
        },$infoList);

        return $infoList;
    }

    /**
     * Gets today's api information
     *
     * @param $today
     * @return array
     */
    public function getApiToday($today)
    {
        $day = date("Ymd",strtotime($today));
        $apiList = RedisDB::ZRange($day,0,-1,true);

        $apiInfo = [];
        foreach($apiList as $api=>$num){
            $apiInfo[$api] = RedisDB::LRange($api,0,$num-1);
        }
        return $apiInfo;
    }

    /**
     * Gets the day to delete.
     *
     * @param $retainDays
     * @return mixed
     */
    public function getToDelDays($retainDays)
    {
        $days = RedisDB::call(Lua::getToDelDays(),1,0,$retainDays,self::APITIMESETNAME);
        return $days;
    }

    /**
     * Arrange the log.
     *
     * @param $days
     */
    public function neatenLog($days)
    {
        // First clean everyday's api log
        foreach($days as $day)
        {
            $apiInfo = RedisDB::ZRange($day,0,-1,true);

            foreach($apiInfo as $api=>$accessNum){
                $this->popApi($api,$accessNum);
            }

            // clean day info
            RedisDB::del($day);

            // del day from time set
            RedisDB::ZRem(SELF::APITIMESETNAME,$day);
        }
    }

    protected function popApi($api,$accessNum)
    {
        for($num = 0;$num<$accessNum;$num++){
            RedisDB::RPop($api);
        }
        return ;
    }

    /**
     * Build your own data format.
     */
    protected static function build()
    {
        $key = self::$data['api'];
        $value = json_encode([
            'access_time'=>date("Y-m-d H:i:s",self::$data['time']),
            'client_ip'=>self::$data['ip'],
            'access_param'=>self::$data['param']
        ]);

        // Get the time of day.
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
         * The first parameter represents the number of keys
         * --------------------------------------------------
         * The second parameter represents that which db to store data
         * ---------------------------------------------------
         * The last is the data you want to operate
         */
        return RedisDB::call(Lua::storeLogEval(),1,0,$data[0],$data[1],$data[2],self::APITIMESETNAME);
    }
}