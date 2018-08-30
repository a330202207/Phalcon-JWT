<?php
/**
 * @purpose: RSA 加解密算法
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/22
 */


namespace core\library\security;


class RSA
{

    public $privateKey = ''; //私钥

    public $publicKey = ''; //公钥

    public function __construct()
    {
        $resource = openssl_pkey_new();
        openssl_pkey_export($resource, $this->privateKey);
        $detail = openssl_pkey_get_details($resource);
        $this->publicKey = $detail['key'];
    }

    /**
     * @notes: 公钥加密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/22
     * @param $data
     * @param $publicKey
     * @return mixed
     */
    public function publicEncrypt($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    /**
     * @notes: 公钥解密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/22
     * @param $data
     * @param $publicKey
     * @return mixed
     */
    public function publicDecrypt($data, $publicKey)
    {
        openssl_public_decrypt($data, $decrypted, $publicKey);
        return $decrypted;
    }

    /**
     * @notes: 私钥加密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/22
     * @param $data
     * @param $privateKeyopenssl_get_privatekey
     * @return mixed
     */
    public function privateEncrypt($data, $privateKey)
    {
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }

    /**
     * @notes: 私钥解密
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/22
     * @param $data
     * @param $privateKey
     * @return mixed
     */
    public function privateDecrypt($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }

    public function rsaSign(array $data, $privateKey)
    {
        $string = Security::prepareSignatureData($data);
        $privateKey = openssl_pkey_get_private($privateKey);
        openssl_sign($string, $sign, $privateKey);
        openssl_free_key($privateKey);
        return base64_encode($sign);
    }

}