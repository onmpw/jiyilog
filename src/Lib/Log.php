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

class Log
{
    private $api = '';

    private $param = '';

    private $ip = '';

    private $storeObj;


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
    protected function setIp($ip = '')
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