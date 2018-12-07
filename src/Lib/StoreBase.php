<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/7
 * Time: 16:45
 */

namespace Onmpw\JiyiLog\Lib;


class StoreBase
{
    protected $log;

    public function _store()
    {

    }

    public function register($log)
    {
        $this->log = $log;
    }
}