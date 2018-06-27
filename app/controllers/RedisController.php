<?php
/**
 * Redis测试实例.
 * User: hwbaker
 * Date: 2018/6/26
 * Time: 16:28
 */


class RedisController
{
    public function redisDemo()
    {
        $redisConn = RedisConnect::getInstanceRedis();
        $userInfo = $redisConn->hGet('user:1:info', 'name');
        echo 'user:1:info->name: ' . print_r($userInfo, true);

        $redisConn->hSet('user:1:info', 'age', 25);
        $userInfo = $redisConn->hGet('user:1:info', 'age');
        echo "<br>";
        echo 'user:1:info->age: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hGetAll('user:1:info');
        echo "<br>";
        echo 'user:1:info->all: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hVals('user:1:info');
        echo "<br>";
        echo 'user:1:info->vals: ' . print_r($userInfo, true);
        $userInfo = $redisConn->hKeys('user:1:info');
        echo "<br>";
        echo 'user:1:info->keys: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hDel('user:1:info', 'height,weight');
        echo "<br>";
        echo 'user:1:info->del: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hLen('user:1:info');
        echo "<br>";
        echo 'user:1:info->hLen: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hSetNx('user:1:info', 'age', '30');
        var_dump($userInfo);
        $userInfo = $redisConn->hSetNx('user:1:info', 'height', '180cm');
        var_dump($userInfo);

        $userInfo = $redisConn->hMset('user:1:info', array('height' => '180'));
        echo 'hMset: ';
        print_r($userInfo);

        $userInfo = $redisConn->hMget('user:1:info', 'name,age,height');
        echo "<br>";
        echo 'user:1:info->hMget: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hIncrBy('user:1:info', 'height', -2);
        echo "<br>";
        echo 'user:1:info->hIncrBy height: ' . print_r($userInfo, true);

        $userInfo = $redisConn->hIncrByFloat('user:1:info', 'height', -2.555);
        echo "<br>";
        echo 'user:1:info->hIncrByFloat height: ' . print_r($userInfo, true);


        $client = $redisConn->getRedisConn();
        var_dump($client->hKeys('user:1:info'));

//        $pool = new \Cache\Adapter\Redis\RedisCachePool($client);
//        $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);
//        $simpleCache->set('A', 'A1');
    }
}