<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/6/26
 * Time: 16:32
 */

class RedisConnect
{
    const REDIS_HOST = '127.0.0.1';
    const REDIS_PORT = 6379;
    const REDIS_TIMEOUT = 1.0;

    private static $instance;
    private $redis;

    /**
     * RedisConnect constructor.
     */
    private function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect(self::REDIS_HOST, self::REDIS_PORT, self::REDIS_TIMEOUT);
    }

    /**
     * @desc 私有化克隆函数，防止类外克隆对象
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @desc 类的唯一公开静态方法，获取类单例的唯一入口
     * @return RedisConnect
     */
    public static function getInstanceRedis()
    {
        if (!self::$instance instanceof self) {
            echo "first...<br>";
            self::$instance = new self();
        }

        echo "copy...<br>";
        return self::$instance;
    }

    /**
     * @desc 获取redis的连接实例
     * @return Redis
     */
    public function getRedisConn()
    {
        return $this->redis;
    }

    /**
     * @desc 需要在单例切换的时候做清理工作
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        self::$instance->redis->close();
        self::$instance = null;
    }

    /*****************hash表操作函数-sta*******************/

    /**
     * @desc 为hash表中的一个字段设定值
     * @param $key
     * @param $field
     * @param $value
     * @return int
     */
    public function hSet($key, $field, $value)
    {
        return $this->redis->hSet($key, $field, $value);
    }

    /**
     * @desc 得到hash表中的一个值
     * @param $key
     * @param $field
     * @return string
     */
    public function hGet($key, $field)
    {
        return $this->redis->hGet($key, $field);
    }

    /**
     * @desc 返回所有hash表的字段值，为一个关联数组
     * @param $key
     * @return mixed
     */
    public function hGetAll($key)
    {
        return $this->redis->hGetAll($key);
    }

    /**
     * @desc 返回所有hash表的字段值，为一个索引数组
     * @param $key
     * @return array
     */
    public function hVals($key)
    {
        return $this->redis->hVals($key);
    }

    /**
     * @desc 返回所有hash表的字段
     * @param $key
     * @return array
     */
    public function hKeys($key)
    {
        return $this->redis->hKeys($key);
    }

    /**
     * @desc 删除hash表字段的值，删除多个字段用,分隔
     * @param $key
     * @param $fields
     * @return int
     */
    public function hDel($key, $fields)
    {
        $fieldArr = explode(',', $fields);
        $num = 0;

        foreach ($fieldArr as $row) {
            $num += $this->redis->hDel($key, trim($row));
        }

        return $num;
    }

    /**
     * @desc 返回hash表元素个数
     * @param $key
     * @return int
     */
    public function hLen($key)
    {
        return $this->redis->hLen($key);
    }

    /**
     * @desc 设定hash表的不存在的字段值。如果存在返回false
     * @param $key
     * @param $field
     * @param $value
     * @return bool
     */
    public function hSetNx($key, $field, $value)
    {
        return $this->redis->hSetNx($key, $field, $value);
    }

    /**
     * @desc 为hash表多个字段设定值
     * @param $key
     * @param array $value
     * @return bool
     */
    public function hMset($key, array $value)
    {
        if (!is_array($value)) {
            return false;
        }
        return $this->redis->hMset($key, $value);
    }

    /**
     * @desc 获取hash表多个字段值
     * @param $key
     * @param $field
     * @return array
     */
    public function hMget($key, $field)
    {
        if (!is_array($field)) {
            $field = explode(',', $field);
        }

        return $this->redis->hMGet($key, $field);
    }

    /**
     * @desc 为hash表字段设整数累加,$value可为负数
     * @param $key
     * @param $field
     * @param int $value
     * @return int
     */
    public function hIncrBy($key, $field, $value)
    {
        $value = intval($value);
        return $this->redis->hIncrBy($key,$field, $value);
    }

    /**
     * @desc 为hash表字段设浮点数累加,$value可为负数
     * @param $key
     * @param $field
     * @param $value
     * @return float
     */
    public function hIncrByFloat($key, $field, $value)
    {
        $value = floatval($value);
        return $this->redis->hIncrByFloat($key,$field, $value);
    }

    /**
     * @desc 判断hash表中指定的字段是否存在
     * @param $key
     * @param $field
     * @return bool
     */
    public function hExists($key, $field)
    {
        return $this->redis->hExists($key, $field);
    }
    /*****************hash表操作函数-end*******************/


    /*****************List列表操作函数-sta******************/

    /**
     * @desc 将一个元素插入列表头部
     * @param $key
     * @param $value
     * @return int
     */
    public function lPush($key, $value)
    {
        return $this->redis->lPush($key, $value);
    }

    /**
     * @desc 将一个元素插入到已存在的列表头部，列表不存在时操作无效
     * @param $key
     * @param $value
     * @return int
     */
    public function lPushx($key, $value)
    {
        return $this->redis->lPushx($key, $value);
    }

    /**
     * @desc 获取列表指定范围内的元素
     * @param $key
     * @param $sta
     * @param $end
     * @return array
     */
    public function lRange($key, $sta, $end)
    {
        return $this->redis->lRange($key, $sta, $end);
    }

    /**
     * @desc 在列表的元素前或者后插入元素
     * @param $key
     * @param $position
     * @param $pivot
     * @param $value
     * @return int
     */
    public function lInsert($key, $position, $pivot, $value )
    {
        return $this->redis->lInsert($key, $position, $pivot, $value );
    }

    /**
     * @desc 通过索引获取列表中的元素
     * @param $key
     * @param $index
     * @return String
     */
    public function lIndex($key, $index)
    {
        return $this->redis->lIndex($key, $index);
    }

    /**
     * @desc 获取列表长度
     * @param $key
     * @return int
     */
    public function lLen($key)
    {
        return $this->redis->lLen($key);
    }

    /**
     * @desc 移出并获取列表的第一个元素
     * @param $key
     * @return string
     */
    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }

    /**
     * @desc 根据参数 COUNT 的值，移除列表中与参数 VALUE 相等的元素
     * @param $key
     * @param $count
     * @param $value
     * @return int
     */
    public function lRem($key, $count, $value)
    {
        return $this->redis->lRem($key, $value, $count);
    }

    /**
     * @desc 通过索引设置列表元素的值
     * @param $key
     * @param $index
     * @param $value
     * @return bool
     */
    public function lSet($key, $index, $value)
    {
        return $this->redis->lSet($key, $index, $value);
    }

    /**
     * @desc 对一个列表进行修剪(trim)，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除
     * @param $key
     * @param $sta
     * @param $stop
     * @return array
     */
    public function lTrim($key, $sta, $stop)
    {
        return $this->redis->lTrim($key, $sta, $stop);
    }

    /**
     * @desc 将一个元素加入列表尾部
     * @param $key
     * @param $value
     * @return int
     */
    public function rPush($key, $value)
    {
        return $this->redis->rPush($key, $value);
    }

    /**
     * @desc 将一个元素插入到已存在的列表尾部。如果列表不存在，操作无效
     * @param $key
     * @param $value
     * @return int
     */
    public function rPushx($key, $value)
    {
        return $this->redis->rPushx($key, $value);
    }

    /**
     * @desc 移除并获取列表最后一个元素
     * @param $key
     * @return string
     */
    public function rPop($key)
    {
        return $this->redis->rPop($key);
    }

    /**
     * @desc 移除srcKey列表的最后一个元素，并将该元素添加到另一个列表desKey并返回
     * @param $srcKey
     * @param $desKey
     * @return string
     */
    public function rPopLPush($srcKey, $desKey)
    {
        return $this->redis->rpoplpush($srcKey, $desKey);
    }

    /**
     * @desc 移出并获取列表的第一个元素，如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止
     * @param $key
     * @param $timeOut
     * @return array
     */
    public function bLPop($key, $timeOut)
    {
        return $this->redis->blPop($key, $timeOut);
    }

    /**
     * @desc  移出并获取列表的最后一个元素，如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止
     * @param $key
     * @param $timeOut
     * @return array
     */
    public function bRPop($key, $timeOut)
    {
        return  $this->redis->brPop($key, $timeOut);
    }

    /**
     * @desc 从列表中弹出一个值，将弹出的元素插入到另外一个列表中并返回它；如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止
     * @param $srcKey
     * @param $dstKey
     * @param $timeOut
     * @return string
     */
    public function bRPopLPush($srcKey, $dstKey, $timeOut)
    {
        return $this->redis->brpoplpush($srcKey, $dstKey, $timeOut);
    }

    /*****************List列表操作函数-end******************/

    /*****************集合操作函数-sta******************/

    /**
     * @desc 集合中添加元素
     * @param $key
     * @param array $values
     * @return bool
     */
    public function sAddArray($key, array $values)
    {
        if (!is_array($values)) {
            return false;
        }

        return $this->redis->sAddArray($key, $values);
    }

    /**
     * @desc 获取集合元素
     * @param $key
     * @return int
     */
    public function sCard($key)
    {
        return $this->redis->sCard($key);
    }

    /**
     * @desc 返回给定结合之间的差集.key1-key2
     * @param $key1
     * @param $key2
     * @return array
     */
    public function sDiff($key1, $key2)
    {
        return $this->redis->sDiff($key1, $key2);
    }

    /**
     * @desc 将给定集合之间的差集存储在指定的集合中。如果指定的集合 key 已存在，则会被覆盖。
     * @param $dstKey
     * @param $key1
     * @param $key2
     * @return int
     */
    public function sDiffStore($dstKey, $key1, $key2)
    {
        return $this->redis->sDiffStore($dstKey, $key1, $key2);
    }

    /**
     * @desc 返回给定所有给定集合的交集
     * @param $key1
     * @param $key2
     * @return array
     */
    public function sInter($key1, $key2)
    {
        return $this->redis->sInter($key1, $key2);
    }

    /**
     * @desc 将给定集合之间的交集存储在指定的集合中。如果指定的集合已经存在，则将其覆盖。
     * @param $dstKey
     * @param $key1
     * @param $key2
     * @return int
     */
    public function sInterStore($dstKey, $key1, $key2)
    {
        return $this->redis->sInterStore($dstKey, $key1, $key2);
    }

    /**
     * @desc 返回集合成员
     * @param $key
     * @return array
     */
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }

    /**
     * @desc 判断 member 元素是否是集合 key 的成员
     * @param $key
     * @param $member
     * @return bool
     */
    public function sIsMember($key, $member)
    {
        return $this->redis->sIsMember($key, $member);
    }

    /**
     * @desc  将 member 元素从 source 集合移动到 destination 集合
     * @param $srcKey
     * @param $desKey
     * @param $member
     * @return bool
     */
    public function sMove($srcKey, $desKey, $member)
    {
        return $this->redis->sMove($srcKey, $desKey, $member);
    }

    /**
     * @desc 移除并返回集合中的一个随机元素
     * @param $key
     * @return string
     */
    public function sPop($key)
    {
        return $this->redis->sPop($key);
    }

    /**
     * @desc 返回集合中一个或多个随机元素
     * @param $key
     * @param int $count
     * @return array|string
     */
    public function sRandMember($key, $count = 1)
    {
        return $this->redis->sRandMember($key, intval($count));
    }

    /**
     * @desc 移除集合中一个元素
     * @param $key
     * @param $member
     * @return int
     */
    public function sRem($key, $member)
    {
        return $this->redis->sRem($key, $member);
    }

    /**
     * @desc 返回所有给定两个集合的并集
     * @param $key1
     * @param $key2
     * @return array
     */
    public function sUnion($key1, $key2)
    {
        return $this->redis->sUnion($key1, $key2);
    }

    /**
     * @desc 给定集合的并集存储在 destination 集合中
     * @param $dstKey
     * @param $key1
     * @param $key2
     * @return int
     */
    public function sUnionStore($dstKey, $key1, $key2)
    {
        return $this->redis->sUnionStore($dstKey, $key1, $key2);
    }
    /*****************集合操作函数-end******************/

    /*****************有序集合操作函数-sta******************/

    /**
     * @desc 向有序集合添加一个成员，或者更新已存在成员的分数
     * @param $key
     * @param $score
     * @param $value
     * @return int
     */
    public function zAdd($key, $score, $value)
    {
        return $this->redis->zAdd($key, $score, $value);
    }

    /**
     * @desc 获取有序集合的成员数,集合必须有序
     * @param $key
     * @return int
     */
    public function zCard($key)
    {
        return $this->redis->zCard($key);
    }

    /**
     * @desc 计算在有序集合中指定区间分数的成员数
     * @param $key
     * @param $start
     * @param $end
     * @return int
     */
    public function zCount($key, $start, $end)
    {
        return $this->redis->zCount($key, $start, $end);
    }

    /**
     * @desc 有序集合中对指定成员的分数加上增量 increment
     * @param $key
     * @param $increment
     * @param $member
     * @return float
     */
    public function zIncrBy($key, $increment, $member)
    {
        return $this->redis->zIncrBy($key, $increment, $member);
    }

    /**
     * @desc 通过索引区间返回有序集合成指定区间内的成员。0表示第一个元素，-1表示最后一个元素
     * @param $key
     * @param $start
     * @param $end
     * @return array
     */
    public function zRange($key, $start, $end, $withscores = false)
    {
        return $this->redis->zRange($key, $start, $end, $withscores);
    }

    /**
     * @desc 通过字典区间返回有序集合的成员
     * @param $key
     * @param $min -
     * @param $max (c
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function zRangeByLex($key, $min, $max, $offset = 0, $limit = 0)
    {
        return $this->redis->zRangeByLex($key, $min, $max, $offset, $limit);
    }

    /**
     * @desc Redis Zrangebyscore 返回有序集合中指定分数区间的成员列表。有序集成员按分数值递增(从小到大)次序排列。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * 默认情况下，区间的取值使用闭区间 (小于等于或大于等于)，你也可以通过给参数前增加 ( 符号来使用可选的开区间 (小于或大于)
     * @param $key
     * @param $start
     * @param $end
     * @param array $options
     * @return array
     */
    public function zRangeByScore($key, $start, $end, array $options = array())
    {
        return $this->redis->zRangeByScore($key, $start, $end, $options);
    }

    /**
     * @desc 返回有序集合中指定成员的索引
     * @param $key
     * @param $member
     * @return int
     */
    public function zRank($key, $member)
    {
        return $this->redis->zRank($key, $member);
    }

    /**
     * @desc 移除有序集合中的一个成员
     * @param $key
     * @param $member
     * @return int
     */
    public function zRem($key, $member)
    {
        return $this->redis->zRem($key, $member);
    }

    /**
     * @desc 移除有序集合中给定的排名区间的所有成员(按索引移除)
     * @param $key
     * @param $start
     * @param $end
     * @return int
     */
    public function zRemRangeByRank($key, $start, $end)
    {
       return $this->redis->zRemRangeByRank($key, $start, $end);
    }

    /**
     * @desc 移除有序集合中给定的分数区间的所有成员
     * @param $key
     * @param $start
     * @param $end
     * @return int
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->redis->zRemRangeByScore($key, $start, $end);
    }

    /**
     * @desc 返回有序集合中指定成员的排名，有序集成员按分数值递减(从大到小)排序
     * @param $key
     * @param $member
     * @return int
     */
    public function zRevRank($key, $member)
    {
        return $this->redis->zRevRank($key, $member);
    }

    /**
     * @desc 返回有序集中指定区间内的成员，通过索引，分数从高到低
     * @param $key
     * @param $start
     * @param $end
     * @return array
     */
    public function zRevRange($key, $start, $end, $withscores = false)
    {
        return $this->redis->zRevRange($key, $start, $end, $withscores);
    }

    /**
     * @desc 返回有序集中指定分数区间内的成员，分数从高到低排序
     * @param $key
     * @param $start
     * @param $end
     * @return array
     */
    public function zRevRangeByScore($key, $start, $end)
    {
        return $this->redis->zRevRangeByScore($key, $start, $end);
    }

    /**
     * @desc 通过字典区间返回有序集合的成员，分数从高到低
     * @param $key
     * @param $min
     * @param $max
     * @return array
     */
    public function zRevRangeByLex($key, $min, $max)
    {
        return $this->redis->zRevRangeByLex($key, $min, $max);
    }

    /**
     * 参考：http://redisdoc.com/
     * @desc 计算给定的一个或多个有序集的并集，其中给定 key 的数量必须以 numkeys 参数指定，并将该并集(结果集)储存到 destination 。
     * 默认情况下，结果集中某个成员的 score 值是所有给定集下该成员 score 值之 和
     * @param $Output
     * @param $ZSetKeys
     * @return int
     */
    public function zUnion($Output, $ZSetKeys)
    {
        return $this->redis->zUnion($Output, $ZSetKeys);
    }

    /**
     * @desc 计算给定的一个或多个有序集的交集，其中给定 key 的数量必须以 numkeys 参数指定，并将该交集(结果集)储存到 destination 。
     * 默认情况下，结果集中某个成员的 score 值是所有给定集下该成员 score 值之和
     * @param $Output
     * @param $ZSetKeys
     */
    public function zInter($Output, $ZSetKeys)
    {
        $this->redis->zInter($Output, $ZSetKeys);
    }


    /**
     * @desc 返回有序集中，成员的分数值
     * @param $key
     * @param $member
     * @return float
     */
    public function zScore($key, $member)
    {
        return $this->redis->zScore($key, $member);
    }
    /*****************有序集合操作函数-end******************/

    /*****************字符串操作函数-sta******************/

    /**
     * @desc 如果 key 已经存在并且是一个字符串， APPEND 命令将 value 追加到 key 原来的值的末尾。
     * 如果 key 不存在， APPEND 就简单地将给定 key 设为 value ，就像执行 SET key value 一样。
     * @param $key
     * @param $val
     * @return int
     */
    public function append($key, $val)
    {
        return $this->redis->append($key, $val);
    }

    /**
     * @desc 设置指定 key 的值
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }
    public function setBit($key, $offset, $value)
    {
        return $this->redis->setBit($key, $offset, $value);
    }

    /**
     * @desc 将值 value 关联到 key ，并将 key 的生存时间设为 seconds (以秒为单位)
     * 如果 key 已经存在， SETEX 命令将覆写旧值
     * @param $key
     * @param $ttl
     * @param $value
     * @return bool
     */
    public function setEx($key, $ttl, $value)
    {
        return $this->redis->setex($key, $ttl, $value);
    }

    /**
     * @desc 将 key 的值设为 value ，当且仅当 key 不存在。
     * 若给定的 key 已经存在，则 SETNX 不做任何动作
     * @param $key
     * @param $value
     * @return bool
     */
    public function setNx($key, $value)
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * @desc 用 value 参数覆写(overwrite)给定 key 所储存的字符串值，从偏移量 offset 开始。不存在的 key 当作空白字符串处理
     * @param $key
     * @param $offset
     * @param $value
     * @return string
     */
    public function setRange($key, $offset, $value)
    {
        return $this->redis->setRange($key, $offset, $value);
    }

    /**
     * @desc 返回 key 所储存的字符串值的长度。当 key 储存的不是字符串值时，返回一个错误
     * @param $key
     * @return int
     */
    public function strLen($key)
    {
        return $this->redis->strlen($key);
    }

    /**
     * @desc 获取指定 key 的值
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }
    public function getBit($key, $offset)
    {
        return $this->redis->getBit($key, $offset);
    }

    /**
     * @desc 返回 key 中字符串值的子字符
     * @param $key
     * @param $start
     * @param $end
     * @return string
     */
    public function getRange($key, $start, $end)
    {
        return $this->redis->getRange($key, $start, $end);
    }

    /**
     * @desc 将给定 key 的值设为 value ，并返回 key 的旧值(old value)
     * @param $key
     * @param $value
     * @return string
     */
    public function getSet($key, $value)
    {
        return $this->redis->getSet($key, $value);
    }

    /**
     * @desc 将 key 中储存的数字值增一
     * @param $key
     * @return int
     */
    public function inCr($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * 将 key 所储存的值加上给定的增量值（increment）
     * @param string $key
     * @param int $increment
     * @return int
     */
    public function inCrBy($key, $increment)
    {
        return $this->redis->incrBy($key, intval($increment));
    }

    /**
     * @desc 将 key 所储存的值加上给定的浮点增量值（increment）
     * @param $key
     * @param $valueFloat
     * @return float
     */
    public function inCrByFloat($key, $valueFloat)
    {
        return $this->redis->incrByFloat($key, floatval($valueFloat));
    }

    /**
     * @desc 将 key 中储存的数字值减一
     * @param $key
     * @return int
     */
    public function deCr($key)
    {
        return $this->redis->decr($key);
    }

    /**
     * @desc 所储存的值减去给定的减量值（decrement）
     * @param $key
     * @param $valueInt
     * @return int
     */
    public function deCrBy($key, $valueInt)
    {
        return $this->redis->decrBy($key, $valueInt);
    }

    public function mGet($array)
    {
        return $this->redis->mget($array);
    }
    public function mSet($array)
    {
        return $this->redis->mset($array);
    }
    public function mSetNx($array)
    {
        return $this->redis->msetnx($array);
    }

    /**
     * @desc 这个命令和 SETEX 命令相似，但它以毫秒为单位设置 key 的生存时间，而不是像 SETEX 命令那样，以秒为单位
     * @param $key
     * @param $ttl
     * @param $value
     * @return bool
     */
    public function pSetEx($key, $ttl, $value)
    {
        return $this->redis->psetex($key, $ttl, $value);
    }

    public function bitCount($key)
    {
        return $this->redis->bitCount($key);
    }

    /*****************字符串操作函数-end******************/

}