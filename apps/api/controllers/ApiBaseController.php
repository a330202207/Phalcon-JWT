<?php
/**
 * @purpose: Api 模块基类
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/17
 */

namespace Apps\Api\Controllers;

use core\base\ControllerBase;

class ApiBaseController extends ControllerBase
{
    //不进行校验的路由列表
    protected static $not_check_routes = [
//        'index/index',                         //登录
        'index/gettoken',                      //获取Token
    ];

    public function onConstruct()
    {
        $routes = strtolower($this->router->getControllerName() . '/' . $this->router->getActionName());
        if (in_array($routes, self::$not_check_routes)) {
            $this->is_validation = false;
        }


        parent::onConstruct();
    }


}