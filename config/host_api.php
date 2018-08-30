<?php
/**
 * @purpose: aip地址列表
 * @author: KevinRen<330202207@.com>
 * @date:2018/8/22
 */

$host = [
    //平台接口地址
    'dev' => 'login.dev.com',
//    'test'=> 'login.jndsfs.com',
//    'prd' => 'login.029hch.com',

];

return [

    'wispay' => [
        'pay' => 'https://api.wispay388.com/EBankPay'
    ],

    'galaxypay' => [
        'pay' => 'https://petrichor.xjfeike.com/v2/api/pay'
    ],

    //发起支付
    'runPayment' => $host['dev'] . '/payment/payment/payment',

    'callbackPay' => $host['dev']. '/financial/notify/callbackPay'
];