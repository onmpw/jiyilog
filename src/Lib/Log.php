<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 16:38
 */

namespace Onmpw\JiyiLog\Lib;

use Request;
use Onmpw\JiyiLog\Models\JiyiLog;

class Log implements LogContract
{
    private $api = '';

    private $param = '';

    private $ip = '';

    private $storeObj;

    private $rangeDay = 5;


    public function __construct(StoreContract $store)
    {
        $this->storeObj = $store;

        $this->register();
    }

    /**
     * The function is defined to store api
     * @param $api
     * @param $param
     * @param string $ip
     */
    public function store($api,$param,$ip = '')
    {
        // set api
        $this->setApi($api);

        // set param
        $this->setParam($param);

        // set ip
        $this->setIp($ip);

        $this->handle();
    }

    public function getDays()
    {
        return $this->storeObj->getDays($this->rangeDay);
    }

    public function getDaysByRange($range = 0)
    {
        if($range === 0){
            return $this->getDays();
        }

        if(is_integer($range) && $range > 0){
            $this->rangeDay = $range;
        }

        return $this->getDays();

    }

    /**
     * Gets the api list for the specified date
     *
     * @param $day
     * @return mixed
     */
    public function getApiByDay($day)
    {
        return $this->storeObj->getApiByDay($day);
    }

    /**
     * Gets information about the specified Api
     *
     * @param $api
     * @return mixed
     */
    public function getApiInfo($api)
    {
        return $this->storeObj->getApiInfo($api);
    }

    /**
     * Backup today's data to database.
     *
     * @param $today
     * @return mixed
     */
    public function backUp($today)
    {
        $apiInfo = $this->storeObj->getApiToday($today);

        $insertData = [];
        foreach($apiInfo as $api=>$info){
            foreach($info as $res){
                $res = json_decode($res,true);
                $res['api_name'] = $api;
                $insertData[] = $res;
            }
        }
        return JiyiLog::store($insertData);
    }

    /**
     * Arrange the log and keep only the last 5 days
     *
     * @param int $retainDays
     * @return mixed
     */
    public function neatenLog($retainDays = 5)
    {
        $days = $this->storeObj->getToDelDays($retainDays);

        $res = $this->storeObj->neatenLog($days);
        return $res;
    }

    /**
     * Start to handle the api info
     *
     */
    public function handle()
    {
        $this->storeObj->store();
    }

    /**
     * Set the client ip
     *
     * @param string $ip
     */
    public function setIp($ip = '')
    {
        if(empty($ip)) {
            $ip = Request::getClientIp();
        }
        $this->ip = $ip;
    }

    /**
     * Register The Log Object
     */
    protected function register()
    {
        $this->storeObj->register($this);
    }

    /**
     * Get the api which the client accessed
     *
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Get the param which the client post to the server
     *
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set Param
     *
     * @param $param
     */
    public function setParam($param)
    {
        $this->param = $param;

    }

    /**
     * Set Api
     *
     * @param $api
     */
    public function setApi($api)
    {
        $this->api = $api;
    }


    /**
     * Get The Client Ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }


}