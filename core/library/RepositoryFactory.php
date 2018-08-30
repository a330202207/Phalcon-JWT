<?php
/**
 * @purpose: 仓库工厂
 * @author: NedRen<ned@pproject.co>
 * @date:2018/8/26
 */


namespace core\library;


class RepositoryFactory
{
    /**
     * 仓库对象容器
     * @var array
     */
    private static $_repositories = [];

    /**
     * @notes: 获取仓库对象
     * @author: NedRen<ned@pproject.co>
     * @date: 2018/8/27
     * @param string $namespace
     * @param string $repositoryName
     * @return mixed
     * @throws \Exception
     */
    public static function getRepository(string $namespace, string$repositoryName)
    {
        $repositoryName = $namespace . "\\" . ucfirst($repositoryName) . 'Service';

        if (!class_exists($repositoryName)) {
            throw new \Exception("{$repositoryName}服务不存在");
        }

        if (!isset(self::$_repositories[$repositoryName]) || empty(self::$_repositories[$repositoryName])) {
            self::$_repositories[$repositoryName] = new $repositoryName();
        }

        return self::$_repositories[$repositoryName];
    }

}