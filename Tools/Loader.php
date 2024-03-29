<?php
/**
 * Created by PhpStorm.
 * User: konghy
 * Date: 19-8-26
 * Time: 19-8-26
 */
namespace Tools;

/**
 * Class Loader
 * 单例工厂工具类
 */
class Loader {

    protected static $instanceClass = [];

    /**
     * @param $className
     * @return mixed
     * 单例操作
     */
    public static function sigltion($className) {
        if(!isset(self::$instanceClass[$className])) {
            self::$instanceClass[$className] = app($className);
        }
        return self::$instanceClass[$className];
    }
}