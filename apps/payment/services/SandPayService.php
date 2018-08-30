<?php
/**
 * @purpose: 杉德支付
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/26
 */


namespace Apps\Payment\Services;


use core\library\Request;
use core\library\Payment;

class SandPayService extends PaymentBaseService implements Payment
{


    /**
     * @notes: 发起支付
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param array $params
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \core\library\ApiException
     */
    public static function payment(array $params)
    {
        $request_uri = getDI()->getApiList()->sandpay;

        $response = Request::Go($request_uri, $params, 'POST', 'form_params');

        if (!empty($response)) {
            return $response;
        } else {
            throw new \Exception('请求出错');
        }
    }

    /**
     * @notes: 组建支付数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param array $params
     * @return array
     */
    public static function buildData(array $params)
    {
        $data = [];
        return $data;
    }

    /**
     * @notes: 验签数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed
     */
    public static function verifyData(array $params)
    {

    }

    /**
     * @notes: 支付回调平台
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     */
    public static function callBackPayment(array $params)
    {

    }
}