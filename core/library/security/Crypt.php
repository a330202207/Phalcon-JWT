<?php


namespace core\library\security;

interface Crypt
{

    /**
     * @notes: 加密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param $str
     * @param $key
     * @return mixed
     */
    public static function encrypt($str, $key);

    /**
     * @notes: 解密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param $str
     * @param $key
     * @return mixed
     */
    public static function decrypt($str, $key);

}
