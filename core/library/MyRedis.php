<?php

namespace core\library;

use Phalcon\Di;


class MyRedis
{

    protected $_instance;

    public function __construct()
    {
        try {
            $redis = Di::getDefault()->getRedis();
            if (!$redis) {
                throw new \Exception('Redis链接失败', -1);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public static function getRedis()
    {
        $redis = Di::getDefault()->getRedis();
        if (!$redis)
            throw new \Exception('Error in MyRedis::create(): can not get redis from Di!', -1);
        return $redis;
    }

    public static function get(string $key, &$val): bool
    {
        $rds = self::getRedis();
        if ($rds) {
            $ret = $rds->get($key);
            if (false !== $ret) {
                $val = $ret;
                return true;
            }
        }

        return false;
    }


    /*
     * parameters: $tagExpire(用于查找相应的timeout)
     */
    public static function set(string $key, $val, string $tagExpire): bool
    {
        $rds = self::getRedis();
        if ($rds) {
            $expire = Lifetime::get($tagExpire);
            return $rds->setEx($key, $expire, $val);
        }
        return false;
    }

    public static function RedisSet(string $key, $val)
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->set($key, $val);
        }
        return false;
    }

    public static function RedisGet(string $key)
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->get($key);
        }
        return false;
    }


    /**
     * @param $key
     * @return bool
     * @throws MyException
     * DateTime: 2018/7/5 22:14
     */
    public static function keys($key)
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->keys($key);
        }
        return false;
    }

    public static function setNx(string $key, $val, string $tagExpire): bool
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->setNx($key, $val) ? $rds->expire($key, $tagExpire) : false;
        }
        return false;
    }


    public static function setString(string $key, string $val, string $tagExpire)
    {
        $rds = self::getRedis();
        if ($rds) {
            $expire = Lifetime::get($tagExpire);
            return $rds->rawCommand('setEx', $key, $expire, $val);
        }
        return false;
    }

    /*
     * parameter: $keyPat 通配，例如: test-*
     */
    public static function cleanKeys(string $keyPat)
    {
        $rds = self::getRedis();
        $arr = $rds->keys($keyPat);
        foreach ($arr as $key) {
            $rds->del($key);
        }
    }

    public static function lockKey($key): bool
    {
        $rds = self::getRedis();
        return Util::retryBoolFunc(9, 100, array($rds, 'setNx'), $key, 'on');
    }

    public static function delockKey($key)
    {
        $rds = self::getRedis();
        return $rds->delete($key);
    }


    public static function hmset($key, $value)
    {
        if (!is_array($value)) return;
        $rds = self::getRedis();
        return $rds->hmset($key, $value);
    }

    public static function hset($key, $field, $value)
    {
        $rds = self::getRedis();
        return $rds->hset($key, $field, $value);
    }

    public static function hget($key, $field)
    {
        $rds = self::getRedis();
        return $rds->hget($key, $field);
    }


    public static function getkeys($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->keys($key);
    }


    public static function hgetAll($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hgetall($key);
    }

    public static function isExists($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->exists($key);
    }

    public static function hDel($key, $value)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hDel($key, $value);
    }

    public static function hKeys($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hKeys($key);
    }
}
