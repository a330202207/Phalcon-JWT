<?php
/**
 * @purpose: 控制器基类
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

namespace core\base;

use Phalcon\Mvc\Controller;
use Phalcon\Debug;

if (APP_DEBUG) {
    $debug = new Debug();
    $debug->listen();
}

class ControllerBase extends Controller
{

    /**
     * ajax输出
     * @param $message
     * @param int $code
     * @param array $data
     * @author Marser
     */
//    protected function ajax_return($message, $code = 1, array $data = [])
//    {
//        $result = [
//            'code' => $code,
//            'message' => $message,
//            'data' => $data,
//        ];
//        $this->response->setJsonContent($result);
//        $this->response->send();
//    }
}
