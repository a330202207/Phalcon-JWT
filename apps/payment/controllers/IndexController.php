<?php
/**
 * @purpose: 默认控制器
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */
namespace Apps\Payment\Controllers;


class IndexController extends PaymentBaseController
{

    public function indexAction()
    {
        echo "<h1>Hello2</h1>";
    }

    /**
     * 404页面
     */
    public function notfoundAction()
    {
        return $this->response->setHeader('status', '404 Not Found');
    }

}

