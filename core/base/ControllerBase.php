<?php
/**
 * @purpose: 控制器基类
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

namespace core\base;

use Phalcon\Mvc\Controller;
use Phalcon\Debug;
//use core\library\ApiException;
use core\common\ErrorCode;
use core\library\Jwt\Token;
use core\library\security\KeyConfig;
use core\library\security\Secret;


if (APP_DEBUG) {
    $debug = new Debug();
    $debug->listen();
}

class ControllerBase extends Controller
{
    private $token;
    private $key;   //密钥
    private $iss;   //发行者(iss)
    private $aud;   //接收方(aud)
    private $jti;   //自定义标识(jti)


    protected $is_validation = true; //是否进行认证校验

    protected $payload = []; //令牌有效载荷
    protected $claims = []; //令牌数据


    public function onConstruct()
    {
        try {

            if (true === $this->is_validation) {
                $this->token = $this->params('token', null) ?: $this->request->getHeader('token');
                $this->key = $this->params('key', Token::DEFAULT_KEY);
                $this->iss = $this->params('iss', '');
                $this->aud = $this->params('aud', '');
                $this->jti = $this->params('jti', null);



                //令牌不存在
                if (empty($this->token)) {
                    echo 1;
//                    throw new ApiException(null, ErrorCode::AUTHORIZE_TOKEN_NOT_EXISTS);
                }
                $bool = Token::validationToken($this->token, $this->key, $this->iss, $this->aud, $this->jti); //验证令牌

                if (true === $bool) {
                    $parserToken = Token::parserToken($this->token, $this->key);

                    if (false === $parserToken) {
                        echo 2;
//                        throw new ApiException(null, ErrorCode::AUTHORIZE_TOKEN_PARSER_FAILED);
                    }
                    $this->payload = explode('.', $this->token);
                    $this->claims = json_decode(json_encode(array_merge($parserToken->getHeaders(), $parserToken->getClaims())), true); //解析令牌
                } else {
                    echo 3;
//                    throw new ApiException(null, ErrorCode::AUTHORIZE_TOKEN_VALIDATION_FAILED);
                }
            }
        } catch (\Exception $exception) {
            echo 4;
//            throw new ApiException($exception->getMessage(), $exception->getCode() != 0 ? $exception->getCode() : ErrorCode::FAILED);
        }
    }

    /**
     * @notes: 获取请求参数
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param null $name 参数名称，不传则为获取所有参数
     * @param string $default 默认值
     * @param null $filter 过滤函数，可以使用,分割的字符串以及正则表达式
     * @param bool $is_validate 是否验证，如果该值不为false，则会对参数进行校验，例如参数为空或不合法等，如果该值为字符串，则提示信息为该值
     * @return array|mixed|null|string
     * @throws ApiException
     */
    public function params($name = null, $default = '', $filter = null, $is_validate = false)
    {

        if ($value = $this->request->get($name)) {
            $input = $value;
            if (isset($input['_url'])) {
                unset($input['_url']);
            }
        }
        if (empty($input)) {
            $input_string = file_get_contents('php://input');
            $input_data = json_decode($input_string, true);
            if (is_array($input_data)) {
                $input = $input_data;
            } else {
                $input = [];
            }
        }
        if (empty($name)) { //获取全部变量
            $data = $input;
            $filters = isset($filter) ? $filter : 'htmlspecialchars';
            if ($filters) {
                if (is_string($filters)) {
                    $filters = explode(',', $filters);
                }
                foreach ($filters as $filter) {
                    $data = array_map_recursive($filter, $data); //参数过滤
                }
            }
        } elseif ((is_array($input) && isset($input[$name])) || is_string($input)) { //取值操作
            if (is_string($input)) {
                $data = $input;
            } else {
                $data = $input[$name];
            }
            $filters = isset($filter) ? $filter : 'htmlspecialchars';
            if ($filters) {
                if (is_string($filters)) {
                    if (0 === strpos($filters, '/')) {
                        if (1 !== preg_match($filters, (string)$data)) { //支持正则验证
                            if (false !== $is_validate) {
                                debug('[ApiException] 参数获取异常，参数名称：' . $name);
                                throw new ApiException((true !== $is_validate && null !== $is_validate) ? $is_validate : '参数值校验失败', ErrorCode::INVALID_PARAMETER_ERROR);
                            }
                            return isset($default) ? $default : null;
                        }
                    } else {
                        $filters = explode(',', $filters);
                    }
                } elseif (is_int($filters)) {
                    $filters = array($filters);
                }
                if (is_array($filters)) {
                    foreach ($filters as $filter) {
                        if (function_exists($filter)) {
                            $data = is_array($data) ? array_map_recursive($filter, $data) : $filter($data); //参数过滤
                        } else {
                            $data = filter_var($data, is_int($filter) ? $filter : filter_id($filter));
                            if (false === $data) {
                                if (false !== $is_validate) {
                                    debug('[ApiException] 参数获取异常，参数名称：' . $name);
                                    throw new ApiException((true !== $is_validate && null !== $is_validate) ? $is_validate : '参数值校验失败', ErrorCode::INVALID_PARAMETER_ERROR);
                                }
                                return isset($default) ? $default : null;
                            }
                        }
                    }
                }
            }
        } else {
            if (false !== $is_validate) {
                debug('[ApiException] 参数获取异常，参数名称：' . $name);
                throw new ApiException((true !== $is_validate && null !== $is_validate) ? $is_validate : '参数值校验失败', ErrorCode::INVALID_PARAMETER_ERROR);
            }
            $data = isset($default) ? $default : null; //变量默认值
        }
        is_array($data) && array_walk_recursive($data, 'secure_filter');
        return $data;
    }
}
