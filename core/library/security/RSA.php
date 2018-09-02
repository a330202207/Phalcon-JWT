<?php
/**
 * @purpose: RSA 加解密算法
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/22
 */


namespace core\library\security;


class RSA implements Crypt
{
    /**
     * @notes: 加密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param $str
     * @param $private_key
     * @return mixed
     */
    public static function encrypt($str, $private_key)
    {
        $str = arrayToUrlParams($str, true);
        $privateKey = openssl_pkey_get_private($private_key);
        if ($privateKey) {
            $opt = openssl_sign($str, $sign, $privateKey, OPENSSL_ALGO_SHA1);
            if ($opt) {
                openssl_free_key($privateKey);
                /*base64编码*/
                //$sign = base64_encode($sign);
                /*16进制*/
                $sign = strtoupper(bin2hex($sign));
                return $sign;
            }
        }
        return false;
    }


    /**
     * @notes: 解密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param $arr
     * @param $public_key
     * @return mixed
     */
    public static function decrypt($arr, $public_key)
    {
        $data = $arr;
        $sign = $arr['sign'];
        unset($data['sign']);

        $data = arrayToUrlParams($data);
        $res = openssl_get_publickey($public_key);
        if ($res) {
            $result = (bool)openssl_verify($data, pack("H*", $sign), $res, OPENSSL_ALGO_SHA1);
            openssl_free_key($res);
            return $result;
        }
        return false;
    }


}