<?php
/**
 * @purpose: 默认控制器
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */
namespace Apps\Api\Controllers;
use Apps\Api\Services\PaychanService as Paychan;

class PaychanController extends ApiBaseController
{

    /**
     * @notes:渲染充值页面
     * @author: Roland<roland@pproject.co>
     * @date: 2018/8/24
     * @throws \Exception
     */
    public function indexAction()
    {
        //$token = $this->request->get('token');
        $token = '96ebdcb18c73933d2f1fab99bd9f6680';
        $data  = Paychan::getPayList($token);
        //var_dump($data);die;
        $this->view->data = json_encode($data);
        $this->view->partial('payment/recharge');
    }


    /**
     * get all pay type channel list
     * 获取所有支付方式对应的渠道列表
     * */
    public function getPayListAction(){

    }


    /**
     * 404页面
     */
    public function notfoundAction()
    {
        return $this->response->setHeader('status', '404 Not Found');
    }

}

