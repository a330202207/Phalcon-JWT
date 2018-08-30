<?php
/**
 * @purpose: 模块配置
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

return [
    //控制器路径
    'controllers' => ROOT_PATH . '/apps/api/controllers/',

    //后台静态资源URL
    'assets_url' => '/api/',

    //模块在URL中的pathinfo路径名
    'module_pathInfo' => '/api/',

    //视图路径
    'views' => ROOT_PATH . '/apps/api/views/',

    //是否实时编译模板
    'is_compiled' => true,

    //模板路径
    'compiled_path' => ROOT_PATH . '/cache/compiled/api/',

    'platform'=>[
        //平台接口地址
        'dev' => 'login.dev.com',
        'test'=> 'login.jndsfs.com',
        'prd' => 'login.029hch.com',
    ]
];
