<?php
/**
 * @purpose: 模块配置
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

return [
    //控制器路径
    'controllers' => ROOT_PATH . '/apps/payment/controllers/',

    //后台静态资源URL
    'assets_url' => '/payment/',

    //模块在URL中的pathinfo路径名
    'module_pathInfo' => '/payment/',

    //视图路径
    'views' => ROOT_PATH . '/apps/payment/views/',

    //是否实时编译模板
    'is_compiled' => true,

    //模板路径
    'compiled_path' => ROOT_PATH . '/cache/compiled/payment/',

    //模块配置域名
    'domain_url' => 'http://testapi.net',

    'channel_type' => [
        'galaxypay' => '1',
        'wispay' => '2',
        'sandpay' => '3',
    ],

    'payment_interface' =>[
        'galaxypay' => [
            'member_id' => 'eric8c',        //商户号
            'key' => '4e3c66854b914ab0979638c85219e9a8',
            'pay_type' => [
                '2' => 'union_pay',
                '3' => 'wx_wap',
                '4' => 'wx_qrcode',
                '5' => 'wx_jsapi',
                '6' => 'ali_wap',
                '7' => 'ali_qrcode',
                '11' => 'union_qrcode',
                '12' => 'qq_wap',
            ]
        ],
        'sandpay' => [

        ],
        'wispay' => [
            'version' => '20180221',        //版本号
            'member_id' => '001020',        //商户号
            'private_key' => '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKamtplzAZD6lURt
432b5pVJoMz+Hl+mfIxln8YSVfKc/rm8A+ZfqKNAOWB5OpDMJ7s5swPg8o6FqyAr
/bmHj0B2Zyo6TguAdYiFyB2UqC3DGFXYLsgUHPvRNSGu+JgtmKKIl1VzpJvU49cN
j6FGoZEFYa7eYwphwRPpCx1M21mnAgMBAAECgYAKmoz/0ouE+AzLX9qbwXG4igjL
QlgYafV+0XCLH9uMJmUm2Em/PNL0IEAGXXBWikb06MT1ODj2zJaI44OvbGq26wgg
N+ebpp7B8I86MkJ0IoD/CXqg5emEqe2ngd8em9GMXzbr40Q74el+Lp0srEBhm7Gz
ax7S6kO9NmBQhdHYwQJBANFm6g8Mah7huY3WnqZVq+yfnA4ecImCyOAAZ9rkPGIb
2Q1U1KS0EIK4+c103t90qRmjjUjZtUQzxchxM8YBVFECQQDLvGX7344XJYQdExd1
GMaJawCa76iqvuAZNpouCkLQBU8FbsJ8LV+aCHrF2ncsTFjAsE+zHKseXwxumMCC
aKh3AkEAl1BTn84rvOcFi03j1HQhyNnJDZbHYUaFWwBQC6dTTt2qqWx8QAvxxlRe
Bi4Ggtgs/V7m0BapWoBC0kWi0NjTEQJAKK4/tuFWn+yPyrZrMqh1zC6felBsX1up
p58tfg/yc1L8ClupXd45fqo+yY7ryN6dwivyXhNVX8Ue2F6L4f4/1QJAOey1sTMV
asHJHmn0CFs2fX6ZZ+FL2vsrpOjITj5i+Zf2xy0HBWn+4YdiECnJsKZ6mmMy75zn
xCAz2KMhwyj+4g==
-----END PRIVATE KEY-----',
            'public_key' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCahbOazQ7lqg7omwlNkuwLnGMj
GR1tMvlTUPnKTokTB6iuRYQQghcENbC28FTq7RXFCqZ9va2OF26waEgmGB3XYM7E
iQkxDC1uk6l+S4qSJoJvhSHZCWhQm1zKBcxFnaQ9ringyEir893WTO5JZvTky4oZ
/bcLqTp3NFcjEKWzswIDAQAB
-----END PUBLIC KEY-----',
            'pay_type' => [
                '1' => '00',
                '2' => '01',
                '3' => '10',
                '6' => '11',
                '7' => '31',
                '8' => '12',
                '9' => '21',
                '10' => '13',
                '11' => '30',
                '12' => '20',
            ]
        ] ,
    ],
];
