<?php
/**
 * @purpose: 注册自动加载
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/17
 */

$loader = new \Phalcon\Loader();

// 注册 Composer 自动加载
require ROOT_PATH . '/vendor/autoload.php';

/**
 * 注册公共命名空间
 */
$loader->registerNamespaces([
    "core\\base" => ROOT_PATH . '/core/base/',
    "core\\common" => ROOT_PATH . '/core/common/',
    "core\\library" => ROOT_PATH . '/core/library/',
    "core\\service" => ROOT_PATH . '/core/service/',
]);


/**
 * 注册公共方法
 */
$loader->registerFiles([
    ROOT_PATH . '/core/function/framework.php', //框架函数库
    ROOT_PATH . '/core/function/functions.php', //核心函数库
]);

$loader->register(true);

$di->setShared('loader', $loader);

