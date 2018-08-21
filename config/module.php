<?php
/**
 * @purpose: 注册模块
 * @author: NedRen<330202207@.com>
 * @date: 2018/8/17
 */
$application->registerModules([
    "api" => [
        'className' => "Apps\\Api\\Module",
        'path'      => ROOT_PATH . "/apps/api/Module.php"
    ],
    "payment" => [
        'className' => "Apps\\Payment\\Module",
        'path'      => ROOT_PATH . "/apps/payment/Module.php"
    ],
]);