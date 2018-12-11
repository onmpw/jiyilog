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
-- redis.call('lpush',ARGV[3],ARGV[1])
local apiNum = redis.call('zscore',ARGV[3],ARGV[1])

if(apiNum == false) then
    -- Set the api number on 1
    apiNum = 0
end
apiNum = apiNum + 1
redis.call("zadd",ARGV[3],apiNum,ARGV[1])

redis.call('zadd','JIYILOG_API_TIME_SET',0,ARGV[3])

return true
LUA;
    }

    public static function getApiByDay()
    {
        return <<<'LUA'
-- Select db which you want to get data from
redis.call('select',KEYS[1])

-- Get Day ApiList
local api = redis.call('zrange',ARGV[1],ARGV[2],ARGV[3],'WITHSCORES')

return api
LUA;

    }

    public static function getApiInfo()
    {
        return <<<'LUA'
-- Select db which you want to get api from
redis.call('select',KEYS[1])

-- Gets information about the api
local info = redis.call('lrange',ARGV[1],ARGV[2],ARGV[3])

return info
LUA;

    }
}