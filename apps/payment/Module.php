<?php

namespace Apps\Payment;

use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;
use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\Config\Adapter\Php;


class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {

        $loader = new Loader();

        $loader->registerNamespaces([
            "Apps\\Payment\\Controllers" => ROOT_PATH . "/apps/payment/controllers/",
            "Apps\\Payment\\Models"      => ROOT_PATH . "/apps/payment/models/",
            "Apps\\Payment\\Services"    => ROOT_PATH . "/apps/payment/services/",
        ]);
        $loader->register();
    }

    /**
     * DI注册相关服务
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * 加载当前模块配置文件
         * 模块内使用方法：$this->config->名称
         * 注意：该方式与系统本身配置获取方式不同，如需使用系统核心配置请使用Config::get()方式
         */
        if (file_exists(__DIR__ . '/config/config.php')) {
            $di->set('moduleConfig', function () use ($di) {
                return new Config(include __DIR__ . '/config/config.php');
            });
        }

        /** DI注册模块路由服务 */
//        $this->registerRoutersService($di);

        /** DI注册dispatcher服务 */
        $this->registerDispatcherService($di);

        /** DI注册url服务 */
        $this->registerUrlService($di);

        /** DI注册view服务 */
        $this->registerViewService($di);

    }

    /**
     * DI注册模块路由服务
     * @param DiInterface $di
     */
    protected function registerRoutersService(DiInterface $di)
    {
        $di->set('router', function () use ($di) {
            $router = new Router();
            $router->setDefaultModule('api');

            $routerRules = new Php(__DIR__ . "/config/routers.php");

            foreach ($routerRules->toArray() as $key => $value) {

                $router->add($key, $value);
            }

            return $router;
        });
    }

    /**
     * DI注册dispatcher服务
     * @param DiInterface $di
     */
    protected function registerDispatcherService(DiInterface $di)
    {
        $di->set('dispatcher', function () {

            // 创建一个事件管理
            $eventsManager = new EventsManager();

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            //默认设置为后台的调度器
            $dispatcher->setDefaultNamespace('Apps\\Payment\\Controllers');

            return $dispatcher;
        }, true);
    }

    /**
     * DI注册url服务
     * @param DiInterface $di
     */
    protected function registerUrlService(DiInterface $di)
    {
        $config = $di->get('moduleConfig');

        $di->set('url', function () use ($config) {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri($config->module_pathInfo);
            $url->setStaticBaseUri($config->assets_url);
            return $url;
        });
    }

    /**
     * DI注册view服务
     * @param DiInterface $di
     */
    protected function registerViewService(DiInterface $di)
    {
        $config = $di->get('moduleConfig');

        $di->setShared('view', function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->views);
            return $view;
        });
    }
}