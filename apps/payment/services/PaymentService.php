<?php
/**
 * @purpose: 充值服务
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/20
 */

namespace Apps\Payment\Services;

use core\library\Request;
use Apps\Payment\Models\Payment;


class PaymentService extends PaymentBaseService
{

    /**
     * @notes: 发起支付
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/26
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public static function runPayment(array $params)
    {
        $res = self::createPaymentDetail($params);
        return self::getPaymentChannel($params)->payment($res);
    }

    /**
     * @notes: 创建支付记录
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/24
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private static function createPaymentDetail(array $params)
    {
        $payment_Obj = new Payment();

        $res = $payment_Obj->create([
            'order_id' => $params['order_id'],
            'amount' => $params['amount'],
            'card_type' => $params['card_type'],
            'pay_type' => $params['pay_type'],
            'trans_date' => date("Ymd"),
            'trans_time' => date("Hms"),
            'channel' => $params['channel'],
            'from_type' => $params['from_type'],
            'type' => $params['type'],
            'created_at' => time(),
        ]);

        if (!$res) {
            throw new \Exception('创建支付记录失败！');
        }
        $data = $payment_Obj->toArray();
        $data['return_url'] = $params['return_url'];
        return $data;
    }

    /**
     * @notes: 更新支付
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/23
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public static function updatePayment(array $params)
    {
        return self::matchPaymentChannel($params)->updatePayment($params);
    }

}