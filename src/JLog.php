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
        }

        return $this->_log($api,$param);

    }
}