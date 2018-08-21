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
            $data = [];
            $res = PaymentService::Payment($data);
            return $this->jsonApi->return(ErrorCode::SUCCESS, 'Success', $res);
        } catch (\Exception $exception) {
            return $this->jsonApi->return(ErrorCode::FAILED, 'Failed');
        }

    }

}