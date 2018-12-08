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

    protected static $data = [];

    public function __construct()
    {
        if(!empty(self::$data)){
            $this->init();
        }
    }

    /**
     * Build data format and store data
     *
     * @return mixed
     */
    public static function _store()
    {
        $data = static::build();

        return static::handle($data);
    }

    /**
     * Parse the data that is to be stored
     */
    public function parseData()
    {
        $api = $this->log->getApi();

        $ip = $this->log->getIp();

        $param = $this->log->getParam();

        self::$data['api'] = $api;
        self::$data['param'] = $param;
        self::$data['ip'] = $ip;

        // current time
        self::$data['time'] = time();
    }

    /**
     * Register the log object
     *
     * @param LogContract $log
     */
    public function register(LogContract $log)
    {
        $this->log = $log;
    }

    private function init()
    {
        self::$data = [];
    }
}