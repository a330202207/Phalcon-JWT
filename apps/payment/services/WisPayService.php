<?php
/**
 * @purpose: Wispay支付
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/26
 */


namespace Apps\Payment\Services;

use core\library\Request;
use core\library\Payment;
use Apps\Payment\Models\Payment as PaymenModel;
use core\library\security\RSA;

class WisPayService extends PaymentBaseService implements Payment
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
        $request_uri = getDI()->getApiList()->wispay->pay;

        $response = Request::Go($request_uri, $data, 'POST', 'form_params');

        if (!empty($response)) {
            return ['content' => $response, 'url' => ''];
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
        $data = [
            "version" => getDI()->getModuleConfig()->payment_interface->wispay->version,
            "merId" => getDI()->getModuleConfig()->payment_interface->wispay->member_id,
            "transDate" => $params['trans_date'],
            "seqId" => $params['order_id'],
            "transTime" => $params['trans_time'],
            "amount" => $params['amount'],
            "notifyUrl" => getDI()->getModuleConfig()->domain_url . "/payment/payment/callBackPayment",
            "returnUrl" => $params['return_url'],
            "subject" => "充值",
            "body" => "充值",
            "cardType" => $params['card_type'],
            "payType" => getDI()->getModuleConfig()->payment_interface->wispay->pay_type[$params['pay_type']],
            "channel" => $params['channel'],
        ];
        $private_key = getDI()->getModuleConfig()->payment_interface->wispay->private_key;
        $data['sign'] = RSA::encrypt($params, $private_key);//签名
        return $data;
    }

    /**
     * @notes: 验签数据
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed|void
     * @throws \Exception
     */
    public static function verifyData(array $params)
    {
        $public_key = getDI()->getModuleConfig()->payment_interface->wispay->public_key;
        $res = RSA::decrypt($params, $public_key);

        if ($res) {
            throw new \Exception('验签失败！');
        }
    }

    /**
     * @notes: 更新支付记录
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function updatePaymentDetail(array $params)
    {
        $payment_Obj = PaymenModel::findFirst(['seqId' => $params['seqId']]);
        $status = $params['stat'] == '0000' ? 1 : 2;
        $res = $payment_Obj->update([
            'status' => $status,
            'updated_at' => time()
        ]);

        debug(['==========【支付日志-开始】=========='], 'INFO');
        debug(['data' => $params], 'INFO');
        debug(['==========【支付日志-结束】=========='], 'INFO');

        if (!$res) {
            throw new \Exception('创建支付记录失败！');
        } else {
            return [
                'order_id' => $payment_Obj->order_id,
                'amount' => $payment_Obj->amount
            ];
        }
    }

    /**
     * @notes: 支付回调平台
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed|void
     * @throws \core\library\ApiException
     */
    public static function callBack(array $params)
    {
        $request_uri = getDI()->getApiList()->callbackPay;
        Request::Go($request_uri, $params, 'POST');
        return true;
    }

    /**
     * @notes: 更新支付
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @throws \core\library\ApiException
     */
    public static function updatePayment(array $params)
    {
        self::verifyData($params);
        $res = self::updatePaymentDetail($params);
        self::callBack($res);
    }

}