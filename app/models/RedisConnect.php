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
     * @desc 返回集合中一个或多个随元素
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
    
    /*****************有序集合操作函数-end******************/

}