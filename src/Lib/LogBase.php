<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 14:10
 */

namespace Onmpw\JiyiLog\Lib;

use App;

class LogBase
{
    /**
     * 记录日志
     * @param $api
     * @param $param
     * @return bool
     */
    public function _log($api,$param)
    {
        $logObj = App::make(Log::class);
        return $logObj->store($api,$param);
    }

    /**
     * 获取指定从今天开始往前的连续几天的日期
     * @return mixed
     */
    public function _getDays()
    {
        $logObj = App::make(Log::class);

        return $logObj->getDays();
    }

    /**
     * 获取从今天开始前推由range指定的天数
     * @param $range
     * @return mixed
     */
    public function _getDaysByRange($range)
    {
        $logObj = App::make(Log::class);

        return $logObj->getDaysByRange($range);
    }

    /**
     * 获取当前日期的apilog
     * @param $day
     * @return array
     */
    public function _getApi($day)
    {
        $logObj = App::make(Log::class);

        return $logObj->getApiByDay($day);
    }

    /**
     * 获取指定api的详情
     * @param $api
     * @return array
     */
    public function _getApiInfo($api)
    {
        $logObj = App::make(Log::class);

        return $logObj->getApiInfo($api);
    }



}