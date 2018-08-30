<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: accept, content-type, token, key');
header('Access-Control-Expose-Headers: *');
header('content-type:text/html;charset=utf-8');

ini_set('date.timezone','Asia/Shanghai');

defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__));

$runtime = 'dev';

try {

    $di = new Phalcon\DI\FactoryDefault();

    /**
     * 引入const.php
     */
    include ROOT_PATH . '/config/const.php';

    $config = new \Phalcon\Config\Adapter\Php(ROOT_PATH . "/config/config_". RUNTIME .".php");


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

} catch (\Exception $e) {
    if (APP_DEBUG == true) {
        echo $e->getMessage() . '<br>';
        echo '<pre>' . $e -> getFile() . '</pre>';
        echo '<pre>' . $e -> getMessage() . '</pre>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        $log = [
            'file'  => $e -> getFile(),
            'line'  => $e -> getLine(),
            'code'  => $e -> getCode(),
            'msg'   => $e -> getMessage(),
            'trace' => $e -> getTraceAsString(),
        ];
        debug($log, 'debug');
    }
}
