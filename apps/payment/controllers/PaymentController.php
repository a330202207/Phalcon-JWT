<?php
/**
 * @purpose: 支付
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/17
 */


namespace Apps\Payment\Controllers;

use core\common\ErrorCode;
use Apps\Payment\Services\PaymentService;

class PaymentController extends PaymentBaseController
{
    /**
     * @notes: 充值
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/21
     * @return mixed
     */
    public function paymentAction()
    {
        try {
            $data = $this->params();
            $res = PaymentService::runPayment($data);
            return $this->jsonApi->return(ErrorCode::SUCCESS, '充值成功', $res);
        } catch (\Exception $exception) {
            return $this->jsonApi->return(ErrorCode::FAILED, $exception->getMessage());
        }
    }


    /**
     * @notes: 支付回调
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/24
     * @return string
     */
    public function callBackPaymentAction()
    {
        try {
            $arr = ['id' => 3];
            dump($arr);die;
            $data = $this->params();
            $res = PaymentService::updatePayment($data);die;
            if ($res) {
                return json_encode(['code' => 'SUCCESS', 'msg' => '成功']);
            }
        } catch (\Exception $exception) {
            return json_encode(['code' => 'ERROR', 'msg' => $exception->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

}