<?php
/**
 * @purpose: 错误常量
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/20
 */

namespace core\common;

class ErrorCode
{
    const SUCCESS = 0; //成功
    const FAILED = -1; //失败

    //认证
    const AUTHORIZE_TOKEN_NOT_EXISTS = 10001; //认证令牌不存在
    const AUTHORIZE_TOKEN_VALIDATION_FAILED = 10002; //认证令牌验证失败
    const AUTHORIZE_TOKEN_PARSER_FAILED = 10003; //认证令牌解析失败
    const AUTHORIZE_FAILED = 10004; //认证出现错误
    const AUTHORIZE_IP_ILLEGAL = 10005; //认证IP不合法
    const AUTHORIZE_FREQUENCY_LIMIT = 10006; //超出最大次数调用限制



    const INVALID_PARAMETER_ERROR = 40001;//非法参数，无效参数
}