<?php
/**
 * @purpose: 模块配置
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/16
 */

return [
    //控制器路径
    'controllers' => ROOT_PATH . '/apps/payment/controllers/',

    //后台静态资源URL
    'assets_url' => '/payment/',

    //模块在URL中的pathinfo路径名
    'module_pathInfo' => '/payment/',

    //视图路径
    'views' => ROOT_PATH . '/apps/payment/views/',

    //是否实时编译模板
    'is_compiled' => true,

    //模板路径
    'compiled_path' => ROOT_PATH . '/cache/compiled/payment/',
];
