<?php
/**
 * @purpose: 注册服务
 * @author: NedRen<330202207@.com>
 * @date:2018/8/17
 */

use Phalcon\Mvc\Router;
use Phalcon\Config\Adapter\Php;
use core\library\RepositoryFactory;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Http\Response\Cookies;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\Model\Manager;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;


/**
 * DI注册路由服务
 */
$di->set('router', function () use ($di) {
    $router = new Router();
    $router->setDefaultModule('api');

    $routerRules = new Php(ROOT_PATH . "/config/routers.php");

    foreach ($routerRules->toArray() as $key => $value) {
        $router->add($key, $value);
    }

    return $router;
});

/**
 * DI注册aip地址
 */
$di->setShared('apiList', function () use ($di) {
    $apiList = new Php(ROOT_PATH . "/config/host_api.php");
    return $apiList;
});

/**
 * DI注册仓库工厂
 */
$di->set("repository", function () {
    $repository = new RepositoryFactory();
    return $repository;
});

/**
 * DI注册cookies服务
 */
$di->set('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});

/**
 * DI注册日志服务
 */
$di->set('logger', function ($name = 'bxPayment', $filename = null, $type = 'DEBUG') {
    $filePath = ROOT_PATH . '/cache/logs';
    if (is_array($filename) && count($filename) == 2) {
        $filename = array_values($filename);
        $filePath .= '/' . $filename[0];
        $filename = $filename[1];
    } else {
        $filePath .= '/' . strtolower($type);
    }
    is_dir($filePath) or mkdir($filePath, 0777, true);
    if (empty($filename)) {
        $filename = date('Ymd') . '.log';
    }
    $path = $filePath . '/' . $filename;
    if (!file_exists($path)) {
        $fp = fopen($path, 'w');
        chmod($path, 0777);
        fclose($fp);
    }
    // 创建日志频道
    $logger = new Logger($name);
    $formatter = new LineFormatter(null, 'Y-m-d H:i:s');
    $stream = new StreamHandler($path, Logger::class . '::' . strtoupper($type));

    $stream->setFormatter($formatter);
    $logger->pushHandler($stream);
    return $logger;
});

/**
 * DI注册session服务
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/**
 * DI注册system配置
 */
$di->setShared('config', function () use ($config) {
    return $config;
});

/**
 * DI注册DB配置
 */
$di->setShared('db', function () use ($config, $di) {
    $dbConfig = $config->database->dbMaster->toArray();

    if (!is_array($dbConfig) || count($dbConfig) == 0) {
        throw new \Exception("the database config is error");
    }

    if (RUNTIME != 'prd') {
        $eventsManager = new \Phalcon\Events\Manager();
        // 分析底层sql性能，并记录日志
        $profiler = new Phalcon\Db\Profiler();
        $eventsManager->attach('db', function ($event, $connection) use ($profiler, $di) {
            if ($event->getType() == 'beforeQuery') {
                //在sql发送到数据库前启动分析
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                //在sql执行完毕后停止分析
                $profiler->stopProfile();
                //获取分析结果
                $profile = $profiler->getLastProfile();
                $sql = $profile->getSQLStatement();
                $params = $connection->getSqlVariables();
                (is_array($params) && count($params)) && $params = json_encode($params);
                $executeTime = $profile->getTotalElapsedSeconds();

                $message = "{$sql} {$params} {$executeTime}";
                //日志记录
                $di->get('logger', ['bxPayment'])->debug($message);

            }
        });
    }

    $connection = new Mysql([
        "host" => $dbConfig['host'],
        "port" => $dbConfig['port'],
        "username" => $dbConfig['username'],
        "password" => $dbConfig['password'],
        "dbname" => $dbConfig['dbname'],
        "charset" => $dbConfig['charset']
    ]);

    if (RUNTIME != 'prd') {
        /* 注册监听事件 */
        $connection->setEventsManager($eventsManager);
        /* 注册监听事件 */
    }

    return $connection;
});

/**
 * DI注册 modelsManager 服务
 */
$di->setShared('modelsManager', function () use ($di) {
    return new Manager();
});

/**
 * DI注册 jsonApi 服务
 */
$di->setShared('jsonApi', function () use ($di) {
    $validator = new \core\library\Msg($di);
    return $validator;
});

/**
 * DI注册 redis 服务
 */
$di->setShared('redis', function () use ($config, $di) {
    $dbConfig = $config->redis->servers->toArray();
    $count = count($dbConfig);
    //单点
    if (1 == $count) {
        $redis = new \Redis();
        list($host, $port) = explode(':', $dbConfig[0]);
        if (!$redis->connect($host, $port)) {
            return false;
        }
        $redis->auth($cfg->redis->auth ?? '');
    }
    $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
    return $redis;
});

