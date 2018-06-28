<?php
/**
 * Redis测试实例.
 * User: hwbaker
 * Date: 2018/6/26
 * Time: 16:28
 */


class RedisController
{
    /**
     * @desc hash哈希demo
     */
    public function redisHash()
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

    /**
     * @desc sort无需集合demo
     */
    public function redisSort()
    {
        $followKey = 'user:1:follow';
        $redisConn = RedisConnect::getInstanceRedis();
        $userInfo = $redisConn->getRedisConn()->sAdd($followKey, 'it');
        echo $followKey . '->sAdd : ' . print_r($userInfo, true);

        $followKey2 = 'user:2:follow';
        $userInfo = $redisConn->sAddArray($followKey2, array('it1', 'news1'));
        echo "<br>";
        echo $followKey2 . '->sAddArray : ' . print_r($userInfo, true);

        $userInfo = $redisConn->sCard($followKey);
        echo "<br>";
        echo $followKey . '->sCard : ' . print_r($userInfo, true);

        $userInfo = $redisConn->sMembers($followKey);
        echo "<br>";
        echo $followKey . '->sMembers : ' . print_r($userInfo, true);
        $userInfo = $redisConn->sMembers($followKey2);
        echo "<br>";
        echo $followKey2 . '->sMembers : ' . print_r($userInfo, true);

        $userInfo = $redisConn->sDiff($followKey, $followKey2);
        echo "<br>";
        echo '->sDiff 1=>2 : ' . print_r($userInfo, true);

        $userInfo = $redisConn->sDiff($followKey2, $followKey);
        echo "<br>";
        echo '->sDiff 2=>1 : ' . print_r($userInfo, true);

        $redisConn->sDiffStore('destset', $followKey, $followKey2);
        echo "<br>";
        echo '->sDiffStore destset : ' . print_r($redisConn->sMembers('destset'), true);

        $userInfo = $redisConn->sInter($followKey, $followKey2);
        echo "<br>";
        echo '->sInter : ' . print_r($userInfo, true);

        $redisConn->sInterStore('destset', $followKey, $followKey2);
        echo "<br>";
        echo '->sInterStore destset : ' . print_r($redisConn->sMembers('destset'), true);

        $userInfo = $redisConn->sIsMember($followKey, 'it1');
        var_dump($userInfo);

        $redisConn->sMove($followKey2, $followKey, 'news1');
        echo "<br>";
        echo '->sMove : ' . print_r($redisConn->sMembers($followKey), true);

        $userInfo = $redisConn->sRandMember($followKey, 3);
        echo "<br>";
        echo '->sRandMember : ' . print_r($userInfo, true);

        $userInfo = $redisConn->sRem($followKey, 'news1');
        echo "<br>";
        echo '->sRem : ' . print_r($userInfo, true);

        echo "<br>" . $followKey . '->sMembers : ' . print_r($redisConn->sMembers($followKey), true);
        echo "<br>" . $followKey2 . '->sMembers : ' . print_r($redisConn->sMembers($followKey2), true);

        $userInfo = $redisConn->sUnion($followKey, $followKey2);
        echo "<br>";
        echo '->sUnion : ' . print_r($userInfo, true);

        $redisConn->sUnionStore('mytest', $followKey, $followKey2);
        echo "<br>";
        echo '->sUnionStore : ' . print_r($redisConn->sMembers('mytest'), true);

    }
}