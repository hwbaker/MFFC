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

}