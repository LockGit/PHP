<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/17
 * Time: 14:37
 * 静态工厂模式
 * 与简单工厂类似，该模式用于创建一组相关或依赖的对象。
 * 不同之处在于静态工厂模式使用一个静态方法来创建所有类型的对象。
 */

class staticFactory{
    public static function factory($className){
        if(!class_exists($className)){
            exit('error');
        }
        return new $className();
    }
}

interface connect{
    public function connect_db();
}

class mysql implements connect {
    public function connect_db() {
        echo 'mysql connect to db...';
    }
}

class pgsql implements connect{
    public function connect_db() {
        echo 'pgsql connect to db...';
    }
}

staticFactory::factory('mysql')->connect_db();