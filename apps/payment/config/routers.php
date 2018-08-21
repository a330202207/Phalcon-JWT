<?php
/**
 * @purpose: 配置路由规则
 * @author: NedRen<330202207@.com>
 * @date:2018/8/17
 * 实例 ：支持正则
 * $key => ["controller" => "", "action" => ""]
 */
return [
    //payment路由规则
    '/payment/:controller/:action/:params' => [
        'module' => 'api',
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]

];