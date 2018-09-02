<?php
/**
 * @purpose: 系统配置--开发环境
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
        'root_namespace' => 'Payment',
    ],
    'database'=>[
        //数据库连接信息
        'dbMaster' => [
            'adapter'     => 'mysql',
            'host'        => '127.0.0.1',
            'port'        => '3306',
            'username'    => 'root',
            'password'    => 'root',
            'dbname'      => 'platform_test',
            'charset'     => 'utf8',
        ],
        'dbSlave' => [
            'adapter'     => 'mysql',
            'host'        => '192.168.1.28',
            'port'        => '3306',
            'username'    => 'root',
            'password'    => '123Qwe_^slash',
            'dbname'      => 'platform',
            'charset'     => 'utf8',
        ],
        //表前缀
        'prefix' => 'pg',

    ],

    'dbPlatform' => [
        'dbMaster' => [
            'adapter'     => 'mysql',
            'host'        => '10.1.111.68',
            'port'        => '3306',
            'username'    => 'root',
            'password'    => '123Qwe_^slash^',
            'dbname'      => 'platform',
            'charset'     => 'utf8',
        ],
        'dbSlave' => [
            'adapter'     => 'mysql',
            'host'        => '10.1.111.68',
            'port'        => '3306',
            'username'    => 'root',
            'password'    => '123Qwe_^slash^',
            'dbname'      => 'platform',
            'charset'     => 'utf8',
        ]
    ],
    // redis配置
    'redis' => [
        'servers' => [
            '127.0.0.1:6379',
        ],
        'auth' => '1354243', //目前只有启动单点才有效
    ],
];