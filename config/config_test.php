<?php
/**
 * @purpose: 系统配置--生产环境
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/15
 */

return [
    'app' => [
        //日志根目录
        'log_path' => ROOT_PATH . '/cache/logs',

        //模型缓存目录
        'models_cache_path' => ROOT_PATH . '/cache/db/',


        //根命名空间
        'root_namespace' => 'Api',
    ],
    'database'=>[
        //数据库连接信息
        'dbMaster' => [
            'adapter'     => 'mysql',
            'host'        => '127.0.0.1',
            'port'        => '3306',
            'username'    => 'dev',
            'password'    => '',
            'dbname'      => '',
            'charset'     => 'utf8',
        ],
        'dbSlave' => [
            'adapter'     => 'mysql',
            'host'        => '127.0.0.1',
            'port'        => '3306',
            'username'    => 'dev',
            'password'    => '',
            'dbname'      => '',
            'charset'     => 'utf8',
        ],
        //表前缀
        'prefix' => '',

    ],


    // redis配置
    'redis' => [
        'servers' => [
            '127.0.0.1:6379',
        ],
        'auth' => '', //目前只有启动单点才有效
    ],
];