<?php
/**
 * @purpose: Json 返回消息
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/20
 */

namespace core\library;

use \Phalcon\DiInterface;

class Msg
{


    /**
     * DI对象
     * @var \Phalcon|DI
     */
    public $di;

    protected $jsonApiContentType = 'application/vnd.api+json';

    public function __construct(DiInterface $di)
    {
        $this->setDI($di);
    }

    /**
     * DI对象赋值
     * @param DiInterface $di
     */
    public function setDI(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * 获取DI对象
     * @return DI|\Phalcon
     */
    public function getDI()
    {
        return $this->di;
    }


    public function return($errorCode, $errorMsg = null, array $data = null, $status = 200)
    {
        $extraData = [
            'status' => $errorCode,
            'msg' => $errorMsg,
            'data' => $data,
        ];
        return $this->getDI()->getResponse()->setHeader('Content-Type', $this->jsonApiContentType)
            ->setStatusCode($status)
            ->setJsonContent($extraData);
    }


}