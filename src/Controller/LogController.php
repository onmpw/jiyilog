<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/10
 * Time: 13:45
 */

namespace Onmpw\JiyiLog\Controller;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Onmpw\JiyiLog\JLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function showLog(Request $request)
    {
        // 获取当前获取的日期，如果没有则默认为今天
        $current_day = $request->l??'';
        if(!empty($current_day)){
            // 传输过来的日期为加密的数据  所以需要解密
            $current_day = Crypt::decrypt($current_day);
        }else{
            $current_day = date("Y-m-d");
        }

        // 获取最近九天的日期
        $log = new JLog();
        $days = $log->getDays(9);
        $days = array_map(function($day){
            return date("Y-m-d",strtotime($day));
        },$days);

        // 检索每天的日志 按照每个api访问的次数降序排序
        $logs = $log->getApi($current_day);
        $standardFormat = true;
        return view("jiyilog::showlog",compact('logs','standardFormat','days','current_day'));
    }

}