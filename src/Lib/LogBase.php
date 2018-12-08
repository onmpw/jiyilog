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

}