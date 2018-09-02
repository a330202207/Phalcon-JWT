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
        $token = $this->request->get('token');
        $os_type = $this->request->get('os_type');//客户端
        $is_mobile = $this->request->get('is_mobile');
        //$token = '7c316760842413654188ffaf47e95b65';
        $data  = Paychan::getPayList($token);
        $data['os_type']   = $os_type??'';//客户端
        $data['is_mobile'] = $is_mobile??'';
        //var_dump($data);die;
        $this->view->data = json_encode($data);
        $this->view->partial('payment/recharge');
    }


    /**
     *
     * 发起充值
     * */
    public function createAction(){
        $data = $this->request->getPost();
        $data  = Paychan::create();
    }


    /**
     * 404页面
     */
    public function notfoundAction()
    {
        return $this->response->setHeader('status', '404 Not Found');
    }

}

