<?php
/**
 * @purpose: aip地址列表
 * @author: KevinRen<330202207@.com>
 * @date:2018/8/22
 */

$host = [
    //平台接口地址
    'payment'=>[
        'dev' => '',
        'test'=> '',
        'prd' => '',
    ]
];

return [
    'wispay' => [
        'pay' => ''
    ],

    //平台回调地址
    'callbackPay' => $host['platform'][RUNTIME]. '',
];