<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 14:02
 */

namespace Onmpw\JiyiLog;

use Onmpw\JiyiLog\Lib\LogBase;
use App;
use Onmpw\JiyiLog\Lib\Log;
use Request;

class JLog extends LogBase
{
    /**
     * 存储api访问日志
     * @param $api
     * @param array $parameter
     * @return bool
     */
    public function log($api,$parameter = [])
    {
        $param = '';

        if(empty($api)){
            return false;
        }

        if(!empty($parameter) && is_array($parameter)){
            $param = json_encode($parameter);
        }elseif(is_string($parameter)){
            $param = $parameter;
        }

        return $this->_log($api,$param);

    }

    /**
     * 获取从今天开始之前的range天的日期
     * @param int $range
     * @return array|mixed
     */
    public function getDays($range = 0)
    {
        if($range === 0){
            return $this->_getDays();
        }

        if(is_integer($range) && $range > 0) {
            return $this->_getDaysByRange($range);
        }

        return [];
    }

    /**
     * 获取api列表
     *
     * @param $day
     * @return array
     */
    public function getApi($day)
    {
        $day = date("Ymd",strtotime($day));

        return $this->_getApi($day);
    }

    /**
     * 获取api详情
     *
     * @param $api
     * @return mixed
     */
    public function getApiInfo($api)
    {
        $logObj = App::make(Log::class);

        return $logObj->getApiInfo($api);
    }

    /**
     * 备份
     * @param $today
     * @return mixed
     */
    public function backUp($today)
    {
        $logObj = App::make(Log::class);

        return $logObj->backUp($today);
    }

    /**
     * 整理日志 只保留最近几天的
     * @param int $retainDays 指定保留的天数
     * @return mixed
     */
    public function neatenLog($retainDays = 5)
    {
        $logObj = App::make(Log::class);

        return $logObj->neatenLog($retainDays);
    }
}