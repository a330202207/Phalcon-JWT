<?php

/**
 * HTTP请求
 * @author: wangyu <wangyu@ledouya.com>
 * @createTime: 2018/4/17 10:46
 */

namespace core\library\Jwt;

use core\library\ApiException;
use core\common\ErrorCode;
use core\library\security\AES;
use core\library\security\KeyConfig;
use core\library\security\Secret;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Phwoolcon\Cache;
use Phwoolcon\Config;

class Request
{
    private static $instance;
    private $config;
    private $apiList; //API列表
    private $selectName; //选择的名称
    private $requestUri; //请求地址

    private static $token = ''; //令牌
    private static $inside_call = false; //内部调用

    private function __construct($config = null)
    {
        $this->config = $config;
        //如果配置不为空并且是数组，则认为该配置为模块内API列表配置
        if (!empty($config) && is_array($config)) {
            $apiCacheFile = storagePath('cache/loader-api-list.php');
            if (!IS_DEBUG) {
                if (is_file($apiCacheFile)) {
                    $this->apiList = include $apiCacheFile;
                    return true;
                }
            }
            $defaultDomain = Config::get('app.url');
            foreach ($config as $key => $item) {
                if (empty($item)) {
                    continue;
                }
                $domain = $item['domain'];
                if (empty($domain)) {
                    $domain = $defaultDomain;
                }
                $module = $key;
                foreach ($item['urls'] as $k => $v) {
                    if (is_numeric($k)) {
                        $k = str_replace('/', '', $v['router']);
                    }
                    $this->apiList[strtolower($module . '.' . $k)] = rtrim($domain, '/') . '/' . $module . '/' . trim($v['router'], '/');
                }
                unset($domain, $module);
            }
            is_dir($apiCacheDir = dirname($apiCacheFile)) or mkdir($apiCacheDir, 0777, true);
            fileSaveArray($apiCacheFile, $this->apiList);
        }
    }

    private function __clone()
    {
    }

    /**
     * 获取当前对象实例
     * @param mixed $config 配置
     * @return Request
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/17 12:28
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance instanceof self) {
            if (null === $config) {
                $config = self::getModuleApiList();
            }
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 选择API名称
     * @param string $name 名称
     * @param bool $return_uri 是否返回接口地址
     * @return mixed
     * @throws \Exception
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/17 15:13
     */
    public function select($name, $return_uri = false)
    {
        $name = strtolower($name);
        if (!in_array($name, array_flip($this->apiList))) {
            throw new \Exception('选择的接口名称不存在');
        } else {
            $this->selectName = $name;
            $this->requestUri = $this->apiList[$name];
        }
        if (true === $return_uri) {
            return $this->requestUri;
        }
        return self::$instance;
    }

    /**
     * 发送请求
     * @param mixed $select 要选择的API名称
     * @param mixed $data 数据
     * @param string $method 请求方式
     * @param mixed $uri 请求地址
     * @param array $headers 请求头
     * @param string $type 数据类型
     * @param bool $original 返回初始值
     * @return mixed|string
     * @throws \Exception
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/17 15:14
     */
    public function send($select = null, $data = [], $method = 'POST', $uri = null, $headers = [], $type = 'json', $original = false)
    {
        if (!empty($select)) {
            if (!self::$instance instanceof self) {
                self::getInstance();
            }
            $this->select($select);
        }
        $methodList = ['GET', 'POST'];
        if (empty($method) || !in_array(strtoupper($method), $methodList)) {
            $method = 'POST';
        }
        $typeList = ['form_params', 'json', 'body', 'multipart'];
        if (empty($type) || !in_array(strtolower($type), $typeList)) {
            $type = 'json';
        }

        if (empty($uri) && !empty($this->requestUri)) {
            $uri = $this->requestUri;
            if ($authorize_token = getAuthorizeToken()) {
                $headers['token'] = getAuthorizeToken();
            }
        }
        try {
            $client = new GuzzleHttpClient();
            $response = $client->request($method, $uri, [
                $type => $data,
                'headers' => $headers,
                'verify' => false
            ]);
            if (true === $original) {
                return $response;
            }
            $contents = $response->getBody()->getContents();
            if (!empty($contents) && is_json($contents)) {
                //如果数据为json并解析成功
                if ($result = json_decode($contents, 320)) {
                    if (isset($result['data']) && isset($result['data'][ENCRYPT_FIELD_NAME])) {
                        $encrypt_string = $result['data'][ENCRYPT_FIELD_NAME];
                        unset($result['data'][ENCRYPT_FIELD_NAME]);
                        //使用统一令牌解密数据
                        $decrypt_data = Secret::decrypt('AES', $encrypt_string, KeyConfig::SECRET_KEY_AES_LESTORE);
                        //如果解密失败
                        if (empty($decrypt_data)) {
                            $decrypt_data = AES::aes128Decrypt($encrypt_string, Config::get('security.secret_key.data'), Config::get('security.secret_iv.data')); //尝试使用数据解密令牌
                        }
                        if (($json_decode = json_decode($decrypt_data, true)) && is_array($json_decode)) {
                            $result['data'] = array_merge($result['data'], $json_decode);
                            unset($json_decode);
                        }
                        unset($encrypt_string, $decrypt_data);
                    }
                    return $result;
                }
            } elseif (is_xml($contents)) {
                return xml_decode($contents);
            }
            return $contents;
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 直接进行请求
     * @param string $uri 请求地址
     * @param mixed $data 数据
     * @param string $method 请求方式
     * @param array $headers 自定义header
     * @param string $type 数据类型
     * @param bool $original 是否返回初始值
     * @param bool $verify 是否在请求时验证SSL证书行为
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws ApiException
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/5/17 11:14
     */
    public static function Go($uri, $data = null, $method = 'POST', $headers = [], $type = 'json', $original = false, $verify = false)
    {
        $methodList = ['GET', 'POST'];
        if (empty($method) || !in_array(strtoupper($method), $methodList)) {
            $method = 'POST';
        }
        $typeList = ['form_params', 'json', 'body', 'multipart'];
        if (empty($type) || !in_array(strtolower($type), $typeList)) {
            $type = 'json';
        }
        try {
            $client = new GuzzleHttpClient();
            $options = [
                'headers' => $headers,
                'verify' => $verify
            ];
            if (!empty($data)) {
                $options[$type] = $data;
            }
            $response = $client->request($method, $uri, $options);
            if (true === $original) {
                return $response;
            }
            $contents = $response->getBody()->getContents();
            if (!empty($contents) && is_string($contents)) {
                //如果数据为json并解析成功
                if (is_json($contents)) {
                    return json_decode(trim($contents, chr(239) . chr(187) . chr(191)), true);
                }
                if (is_xml($contents)) {
                    return xml_decode($contents);
                }
            }
            return $contents;
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage(), ErrorCode::FAILED);
        }
    }

    /**
     * 获取模块API列表集合
     * @param null $name 要获取的模块名称，默认为所有
     * @return mixed|null
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/21 11:19
     */
    private static function getModuleApiList($name = null)
    {
        if (is_file($apiCacheFile = storagePath('cache/loader-modules-api.php'))) {
            $apiList = include $apiCacheFile;
            if (!empty($name) && isset($apiList[$name])) {
                return $apiList[$name];
            }
            return $apiList;
        }
        return null;
    }

    /**
     * 获取处理后的API列表
     * @return mixed
     * @author wangyu <wangyu@ledouya.com>
     * @createTime 2018/4/21 11:43
     */
    public static function apiList()
    {
        if (!self::$instance instanceof self) {
            self::getInstance();
        }
        return self::$instance->apiList;
    }

}