<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/8
 * Time: 18:59
 */

namespace Onmpw\JiyiLog\Scripts;


class LuaScripts
{
    public static function storeLogEval()
    {
        return <<<'LUA'
-- Select db which you want to store data to
redis.call('select',KEYS[1])

-- Store Api ParamList 
redis.call('lpush',ARGV[1],ARGV[2])

-- Store Time ApiList
redis.call('lpush',ARGV[3],ARGV[1])
LUA;
    }
}