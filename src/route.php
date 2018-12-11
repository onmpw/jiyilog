<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/10
 * Time: 17:41
 */

Route::get('/showlog','Onmpw\JiyiLog\Controller\LogController@showLog');

Route::get('/viewlog','Onmpw\JiyiLog\Controller\LogController@viewlog');