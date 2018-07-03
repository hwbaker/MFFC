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
     * @desc list列表demo
     */
    public function redisList()
    {
        $key = 'mylist';
        $redisConn = RedisConnect::getInstanceRedis();
//        var_dump($redisConn->lPush($key, 'a'));

        $myList = $redisConn->lRange($key, 0, -1);
        echo 'lRange: ' . print_r($myList, true);

        $redisConn->lInsert($key, Redis::AFTER, 'c', 'd');
        $myList = $redisConn->lRange($key, 0, -1);
        echo "<br>";
        echo 'lInsert: ' . print_r($myList, true);

        $ele = $redisConn->lIndex($key, 6);
        echo "<br>";
        echo 'lIndex: ' . print_r($ele, true);

        $len = $redisConn->lLen($key);
        echo "<br>";
        echo 'lLen: ' . print_r($len, true);

        $ele = $redisConn->lPop($key);
        echo "<br>";
        echo 'lPop: ' . print_r($ele, true);
        echo "<br>";
        echo 'lRange: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $redisConn->lPushx($key, 'second');
        echo "<br>";
        echo 'lPushx: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $redisConn->lRem($key, 1, 'd');
        echo "<br>";
        echo 'lRange: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $redisConn->lSet($key, 0 , 'third');
        echo "<br>";
        echo 'lSet: ' . print_r($redisConn->lRange($key, 0, -1), true);

//        $redisConn->lTrim($key, 0, 3);
//        echo "<br>";
//        echo 'lTrim: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $redisConn->rPush($key, 'g');
        echo "<br>";
        echo 'rPush: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $redisConn->rPushx($key, 'h');
        echo "<br>";
        echo 'rPushx: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $pop = $redisConn->rPop($key);
        echo "<br>";
        echo 'rpop:' . print_r($pop, true);
        echo "<br>";
        echo 'lRange: ' . print_r($redisConn->lRange($key, 0, -1), true);

        $desKey = $redisConn->rPopLPush($key, 'desKey');
        echo "<br>";
        echo 'rPopLPush: ' . print_r($desKey, true);
        echo "<br>";
        echo 'lRange: ' . print_r($redisConn->lRange($key, 0, -1), true);

    }

    /**
     * @desc sort有序集合demo
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

    /**
     * @desc zsort有序集合demo
     */
    public function redisZSort()
    {
        $userRankingKey = 'user:ranking';
        $redisConn = RedisConnect::getInstanceRedis();
        $flag = $redisConn->zAdd($userRankingKey, 3, 'c');
        var_dump($flag);

        $zcard = $redisConn->zCard($userRankingKey);
        echo 'zcard：' . print_r($zcard, true);

        $acount = $redisConn->zCount($userRankingKey, 1, $zcard);
        echo "<br>";
        echo 'zcount：' . print_r($acount, true);

        $range = $redisConn->zRange($userRankingKey, 0, -1, true);
        echo "<br>";
        echo 'range：' . print_r($range, true);

        $zRangeByLex = $redisConn->zRangeByLex($userRankingKey, '-', '(c', 0, $zcard);
        echo "<br>";
        echo 'zRangeByLex - (c：' . print_r($zRangeByLex, true);

        $zRangeByScore = $redisConn->zRangeByScore($userRankingKey, 1, 5);
        echo "<br>";
        echo 'zRangeByScore 1 5：' . print_r($zRangeByScore, true);

        $zRank = $redisConn->zRank($userRankingKey, 'a');
        echo "<br>";
        echo 'zRank：' . print_r($zRank, true);

        $zRem = $redisConn->zRem($userRankingKey, 'h');
        echo "<br>";
        echo 'zRem：' . print_r($zRem, true);

//        $zRemRangeByRank = $redisConn->zRemRangeByRank($userRankingKey, 0, 0);
//        echo "<br>";
//        echo 'zRemRangeByRank：' . print_r($zRemRangeByRank, true);

//        $zRemRangeByScore = $redisConn->zRemRangeByScore($userRankingKey, 1, 3);
//        echo "<br>";
//        echo 'zRemRangeByScore：' . print_r($zRemRangeByScore, true);

        $zRevRank = $redisConn->zRevRank($userRankingKey, 'c');
        echo "<br>";
        echo 'zRevRank c：' . print_r($zRevRank, true);

        $zRevRange = $redisConn->zRevRange($userRankingKey, 0, -1, true);
        echo "<br>";
        echo 'zRevRange：' . print_r($zRevRange, true);

        $zRevRangeByScore = $redisConn->zRevRangeByScore($userRankingKey, 7, 4);
        echo "<br>";
        echo 'zRevRangeByScore 7 4：' . print_r($zRevRangeByScore, true);

        $zRevRangeByLex = $redisConn->zRevRangeByLex($userRankingKey, '[i', '[f');
        echo "<br>";
        echo 'zRevRangeByLex [i [f ：' . print_r($zRevRangeByLex, true);

        $zScore = $redisConn->zScore($userRankingKey, 'f');
        echo "<br>";
        echo 'zScore f：' . print_r($zScore, true);

    }
}