<?php

namespace Apps\Api\Services;

use core\library\Request;
use Phalcon\DiInterface;

class PaychanService extends ApiBaseService{

    public static function getPayList(string $token)
    {
        if(empty($token)) return false;

        $api_host =getDI()->get('ModuleConfig')->platform->test;

        $request_uri = $api_host.'/financial/paychan/get/?token='.$token;

        $response = Request::Go($request_uri, '', 'GET');
        //var_dump($response);die;

        if (!empty($response)) {
            return $response;
        } else {
            throw new \Exception('请求出错');
        }
    }


}