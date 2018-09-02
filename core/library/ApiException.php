<?php
/**
 * @purpose: API异常处理
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/22
 */


namespace core\library;


use Phwoolcon\ErrorCodes;
use Throwable;

class ApiException extends \Exception
{
    public function __construct($message = '', int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $errorCode = ErrorCodes::getCodeMsg($code);
            $message = ($errorCode && count($errorCode) == 2) ? $errorCode[1] : '';
        }
        parent::__construct($message, $code, $previous);
    }

    public function getHeaders()
    {
        return [
            'content-type: application/vnd.api+json',
            'exception-type: ApiException',
        ];
    }

    public function getBody()
    {
        return json_encode([
            'status' => $this->getCode(),
            'msg' => $this->getMessage()
        ]);
    }
}