<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: accept, content-type, token, key');
header('Access-Control-Expose-Headers: *');
header('content-type:text/html;charset=utf-8');

ini_set('date.timezone', 'Asia/Shanghai');

defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));

try {

    $di = new Phalcon\DI\FactoryDefault();

    require ROOT_PATH . '/core/library/InvironMent.php';

    /**
     * 引入const.php
     */
    include ROOT_PATH . '/config/const.php';

    $config = new \Phalcon\Config\Adapter\Php(ROOT_PATH . "/config/config_" . RUNTIME . ".php");

    /**
     * 引入loader.php
     */
    include ROOT_PATH . '/config/loader.php';


    /**
     * 引入services.php
     */
    include ROOT_PATH . '/config/services.php';

    /**
     * 处理请求
     */
    $application = new \Phalcon\Mvc\Application($di);

    /**
     * 引入module.php
     */
    include ROOT_PATH . '/config/module.php';

    $di->set('app', $application);

    $response = $application->handle();

    $response->send();

} catch (\Throwable $e) {

    if (RUNTIME != 'prd' && RUNTIME != 'test') {
        echo '<pre>' . $e->getCode() . '</pre>';
        echo '<pre>' . $e->getMessage() . '</pre>';
        echo '<pre>' . $e->getFile() . '</pre>';
        echo '<pre>' . $e->getMessage() . '</pre>';
        echo '<pre>' . nl2br( $e->getTraceAsString()) . '</pre>';
    } else {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $client_ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $client_ip = "0";
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $x_client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $x_client_ip = "0";
        }

        $log = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'msg' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'userIp' => $_SERVER['REMOTE_ADDR'],
            'clientIp' => $client_ip,
            'xClintIp' => $x_client_ip,
        ];
        debug($log, 'debug');
    }
}
