<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/16
 * Time: 00:30
 * 多例模式
 * 多例模式和单例模式类似，但可以返回多个实例。
 * 有多个数据库连接，MySQL、SQLite、Postgres，又或者有多个日志记录器，分别用于记录调试信息和错误信息，这些都可以使用多例模式实现。
 */

class moreInstance{

    private static $instances = array();

    private function __construct() {
    }

    private function __clone() {
    }

    protected function __wakeup() {
    }

    public static function getInstance($instanceName){
        if (!array_key_exists($instanceName, self::$instances)) {
            self::$instances[$instanceName] = new self();
        }

        return self::$instances[$instanceName];
    }
}

$mysql = moreInstance::getInstance('mysql');
$pgsql = moreInstance::getInstance('pgsql');


