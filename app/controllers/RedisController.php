<?php
/**
 * Redis测试实例.
 * User: hwbaker
 * Date: 2018/6/26
 * Time: 16:28
 */


class RedisController
{
    public function redis()
    {
        $redisConn = RedisConnect::getInstanceRedis();
        $client = $redisConn->getRedisConn();

        $pool = new \Cache\Adapter\Redis\RedisCachePool($client);
        $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);
        $simpleCache->set('A', 'A1');

        $redisConn = RedisConnect::getInstanceRedis();
        $client = $redisConn->getRedisConn();
    }
}