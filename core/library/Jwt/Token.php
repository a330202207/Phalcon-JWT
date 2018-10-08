<?php

/**
 * 令牌服务
 * @author: wangyu <wangyu@ledouya.com>
 * @createTime: 2018/4/23 14:35
 */

namespace core\library\Jwt;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class Token
{

    const DEFAULT_KEY = 'x8fe3odTo4o7ff8CzjK9e3Dae59T4d4eKfKJFFEFt7OPj844cejFE4zCaCf9fFFo';

    /**
     * 生成令牌
     * @param array $data 自定义声明（数据）
     * @param string $key 密钥
     * @param string $iss 发行者(iss)
     * @param string $aud 接收方(aud)
     * @param string $jti 自定义标识(jti)
     * @param int $nbf 可以使用令牌的时间(iat)
     * @param int $exp 令牌过期时间(exp)
     * @param bool $custom 自定义
     * @return mixed
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/23 14:58
     */
    public static function builderToken(array $data = [], $key = '', $iss = '', $aud = '', $jti = null, $nbf = 0, $exp = 7200, $custom = false)
    {
        $key = empty($key) ? '' : $key; //创建签名使用的密钥
        $jti = empty($jti) ? '' : $jti; //自定义标识(jti)
        if (false === $custom) {
            $iat = time(); //令牌发行时间(iat)
            $nbf = $iat + $nbf; //可以使用令牌的时间(iat)
            $exp = $iat + $exp; //令牌过期时间(exp)
        } else {
            $iat = $custom['iat'];
            $nbf = $custom['nbf'];
            $exp = $custom['exp'];
        }
        $signer = new Sha256();
        $builder = new Builder();

        //设置header和payload，以下的字段都可以自定义
        $builder = $builder->setIssuer($iss)        //发布者
            ->setAudience($aud)                     //接收者
            ->setId($jti, true)    //对当前token设置的标识
            ->setIssuedAt($iat)                     //token创建时间
            ->setNotBefore($nbf)                    //当前时间在这个时间前，token不能使用
            ->setExpiration($exp);                  //过期时间

        if (!empty($data) && is_array($data)) {
            foreach ($data as $index => $item) {
                $builder->set($index, $item);       //自定义数据
            }
        }
        return $builder->sign($signer, $key)->getToken();
    }

    /**
     * 解析令牌
     * @param null $token
     * @param string $key
     * @return mixed
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/23 15:28
     */
    public static function parserToken($token = null, $key = '')
    {
        $signer = new Sha256();
        $parser = new Parser();
        $token = $parser->parse((string)$token);
        if (!$token->verify($signer, $key)) {
            return false; //签名错误
        }
        return $token;
    }

    /**
     * 验证令牌
     * @param mixed $token
     * @param string $key 密钥
     * @param string $iss 发行者(iss)
     * @param string $aud 观众(aud)
     * @param string $jti 自定义标识(jti)
     * @return bool
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/23 15:13
     */
    public static function validationToken($token = null, $key = '', $iss = '', $aud = '', $jti = null)
    {
        $jti = empty($jti) ? '' : $jti; //自定义标识(jti)
        $token = self::parserToken($token, $key);
        if (!$token) {
            return false;
        }
        $data = new ValidationData();
        $data->setIssuer($iss);
        $data->setAudience($aud);
        $data->setId($jti);
        return $token->validate($data);
    }
}