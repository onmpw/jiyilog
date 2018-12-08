<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/8
 * Time: 9:30
 */

namespace Onmpw\JiyiLog\Lib;


interface LogContract
{
    /**
     * The function is defined to store api
     * @param $api
     * @param $param
     * @param string $ip
     */
    public function store($api,$param,$ip = '');

    /**
     * Get the api which the client accessed
     *
     * @return string
     */
    public function getApi();

    /**
     * Get The Client Ip
     *
     * @return string
     */
    public function getIp();

    /**
     * Get the param which the client post to the server
     *
     * @return string
     */
    public function getParam();

    /**
     * Set the client ip
     *
     * @param string $ip
     */
    public function setIp($ip = '');

    /**
     * Set Api
     *
     * @param string $api
     */
    public function setApi($api);

    /**
     * Set Param
     *
     * @param string $param
     */
    public function setParam($param);
}