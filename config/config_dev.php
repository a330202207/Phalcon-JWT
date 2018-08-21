<?php
/**
 * @purpose: 系统配置--开发环境
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/15
 */
return [
    'app' => [
        //类库路径
        'libs' => ROOT_PATH . '/core/library/',
        //日志根目录
        'log_path' => ROOT_PATH . '/cache/logs/',
        //缓存路径
        'cache_path' => ROOT_PATH . '/cache/data/',

        //根命名空间
        'root_namespace' => 'Payment',
    ],
    'database'=>[
        //数据库连接信息
        'dbMaster' => [
            'adapter'     => 'mysql',
            'host'        => '127.0.0.1',
            'username'    => 'root',
            'password'    => 'root',
            'dbname'      => 'platform_test',
            'charset'     => 'utf8',
        ],
        'dbSlave' => [
            'adapter'     => 'mysql',
            'host'        => '192.168.1.28',
            'username'    => 'root',
            'password'    => '123Qwe_^slash',
            'dbname'      => 'platform',
            'charset'     => 'utf8',
        ],
        //表前缀
        'prefix' => 'pg',

        'dbPlatform' => [
            'adapter'     => 'mysql',
            'host'        => '192.168.1.28',
            'username'    => 'root',
            'password'    => '123Qwe_^slash',
            'dbname'      => 'platform',
            'charset'     => 'utf8',
        ],
    ]
];