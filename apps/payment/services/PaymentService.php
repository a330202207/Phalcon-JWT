<?php
/**
 * @purpose: 充值服务
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/20
 */

namespace Apps\Payment\Services;

use core\library\Request;

class PaymentService extends PaymentBaseService
{

    /**
     * @notes: 充值服务
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/21
     * @param array $params
     */
    public static function Payment(array $params)
    {
        $requestUri = 'https://api.wispay388.com';
        $response = Request::Go($requestUri, null, 'GET');
        var_dump($response);die;

/*        if (!empty($response) && isset($response['error']) && $response['error'] == 0 && isset($response['data'])) {
            return $response;
        } else {
            throw new \Exception('请求出错');
        }*/
    }

}