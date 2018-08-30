<?php
/**
 * @purpose: 银河支付
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/26
 */


namespace Apps\Payment\Services;

use core\library\Request;
use core\library\Payment;

class GalaxyPayService extends PaymentBaseService implements Payment
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
        $data = self::buildData($params);
        $request_uri = getDI()->getApiList()->galaxypay->pay;
        $response = Request::Go($request_uri, $data, 'POST');
        if (!empty($response) && $response['code'] == 0) {
            $content = Request::Go($response['url'], null, 'GET');
            return ['content' => $content, 'url' => $response['url']];
        } else {
            throw new \Exception($response['error']);
        }
    }

    /**
     * @notes: 组建支付数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function buildData(array $params)
    {
        $data = [
            'customer_id' => getDI()->getModuleConfig()->payment_interface->galaxypay->member_id,
            'order_id' => $params['order_id'],
            'total_fee' => $params['amount'],
            'nonce_str' => uuid32(),
            'notify_url' => getDI()->getModuleConfig()->domain_url . "/payment/payment/callBackPayment",
            'callback_url' => $params['return_url'],
            'client_ip' => get_client_ip(),
            'pay_type' => getDI()->getModuleConfig()->payment_interface->galaxypay->pay_type[$params['pay_type']],
            'user_id' => $params['id'],
        ];

        $signData = [
            'customer_id' => $data['customer_id'],
            'nonce_str' => $data['nonce_str'],
            'order_id' => $data['order_id'],
            'total_fee' => $data['total_fee'],
            'key' => getDI()->getModuleConfig()->payment_interface->galaxypay->key,
        ];
        $sign = md5(arrayToUrlParams($signData));
        $data['sign'] = strtolower($sign);
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