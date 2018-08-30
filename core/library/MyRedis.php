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



    static public function getRedis()
    {
        $redis = Di::getDefault()->getRedis();
        if (!$redis)
            throw new \Exception('Error in MyRedis::create(): can not get redis from Di!', -1);
        return $redis;
    }

    static public function get(string $key, &$val): bool
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
    static public function set(string $key, $val, string $tagExpire): bool
    {
        $rds = self::getRedis();
        if ($rds) {
            $expire = Lifetime::get($tagExpire);
            return $rds->setEx($key, $expire, $val);
        }
        return false;
    }

    static public function RedisSet(string $key, $val)
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->set($key, $val);
        }
        return false;
    }

    static public function RedisGet(string $key)
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
    static public function keys($key)
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->keys($key);
        }
        return false;
    }

    static public function setNx(string $key, $val, string $tagExpire): bool
    {
        $rds = self::getRedis();
        if ($rds) {
            return $rds->setNx($key, $val) ? $rds->expire($key, $tagExpire) : false;
        }
        return false;
    }


    static public function setString(string $key, string $val, string $tagExpire)
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
    static public function cleanKeys(string $keyPat)
    {
        $rds = self::getRedis();
        $arr = $rds->keys($keyPat);
        foreach ($arr as $key) {
            $rds->del($key);
        }
    }

    static public function lockKey($key): bool
    {
        $rds = self::getRedis();
        return Util::retryBoolFunc(9, 100, array($rds, 'setNx'), $key, 'on');
    }

    static public function delockKey($key)
    {
        $rds = self::getRedis();
        return $rds->delete($key);
    }


    static public function hmset($key, $value)
    {
        if (!is_array($value)) return;
        $rds = self::getRedis();
        return $rds->hmset($key, $value);
    }

    static public function hset($key, $field, $value)
    {
        $rds = self::getRedis();
        return $rds->hset($key, $field, $value);
    }

    static public function hget($key, $field)
    {
        $rds = self::getRedis();
        return $rds->hget($key, $field);
    }


    static public function getkeys($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->keys($key);
    }


    static public function hgetAll($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hgetall($key);
    }

    static public function isExists($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->exists($key);
    }

    static public function hDel($key, $value)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hDel($key, $value);
    }

    static public function hKeys($key)
    {
        if (empty($key)) return;
        $rds = self::getRedis();
        return $rds->hKeys($key);
    }




    /*
    static public function getObj(string $key, &$val, string $className) :bool {
        if (self::get($key, $obj) && $obj instanceof $className) {
            $val = $obj;
            return true;
        }
        return false;
    }
     */

    /*
     * return: err
     * err = 0: success
     * err = -1: failure, key不存在
     * err = -2: failure, 值不是int
     */
    /*
    static private function getInt_impl(string $key, int &$val) :int {
        $rds = self::getRedis();
        $ret = $rds->get($key);
        if (FALSE === $ret)
            return -1;
        else if (!is_int($ret))
            return -2;

        $val = $ret;
        return 0;
    }

    static public function getInt(string $key) :int {
        $val = 0;
        $ret = self::getBalance_impl($key, $val);
        if (0 == $ret)
            return $val;
        throw new MyException('Error in MyRedis::getInt(): ret=' . $ret, $ret);
    }
     */
}
