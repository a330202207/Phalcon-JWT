<?php
/**
 * @purpose: Payment基类服务
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/20
 */

namespace Apps\Payment\Services;

use core\base\ServiceBase;
use Apps\Payment\Models\Payment;

class PaymentBaseService extends ServiceBase
{

    /**
     * @notes: 获取支付渠道service
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/26
     * @param $params
     * @return mixed
     * @throws \Exception
     * 方法 getRepository()在 core\library\RepositoryFactory
     */
    protected static function getPaymentChannel(array $params)
    {
        switch ($params['type']) {
            case getDI()->getModuleConfig()->channel_type['galaxypay']:
                return getDI()->getRepository()->getRepository(__NAMESPACE__, 'GalaxyPay');
            case getDI()->getModuleConfig()->channel_type['wispay']:
                return getDI()->getRepository()->getRepository(__NAMESPACE__, 'WisPay');
            case getDI()->getModuleConfig()->channel_type['sandpay']:
                return getDI()->getRepository()->getRepository(__NAMESPACE__, 'SandPay');
            default:
                //回滚
                $payment_Obj = Payment::findFirst(['id' => $params['id']]);
                $payment_Obj->delete();
                throw new \Exception('支付渠道错误');
        }
    }

    /**
     * @notes: 匹配支付类型
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/30
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    protected static function matchPaymentChannel(array $params)
    {
        $payment_interface = getDI()->getModuleConfig()->payment_interface->toArray();
        if (isset($params['merId']) && $params['merId'] == $payment_interface['wispay']['member_id']) {
            return getDI()->getRepository()->getRepository(__NAMESPACE__, 'WisPay');
        } elseif (isset($params['customer_id']) && $params['customer_id'] == $payment_interface['galaxypay']['member_id']) {
            return getDI()->getRepository()->getRepository(__NAMESPACE__, 'GalaxyPay');
        } else {
            throw new \Exception('回调错误');
        }
    }
}