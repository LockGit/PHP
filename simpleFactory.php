<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/17
 * Time: 11:53
 * 简单工厂模式
 * 简单工厂的作用是实例化对象，而不需要客户了解这个对象属于哪个具体的子类。
 * 简单工厂实例化的类具有相同的接口或者基类，在子类比较固定并不需要扩展时，可以使用简单工厂。
 */

class dbFactory{
    protected $typeList = [];
    public function __construct() {
        $this->typeList = array(
            'mysql'=>'mysql',
            'oracle'=>'oracle'
        );
    }

    public function getDb($type){
        if(!in_array($type,$this->typeList)){
            exit('error');
        }
        $className = $this->typeList[$type];
        return new $className;
    }

}

/**
 * Interface connect
 */
interface connect{
    public function connect_db();
}

class mysql implements connect{
    public function connect_db() {
        echo 'mysql connect to db server ...';
    }
}

class oracle implements connect{
    public function connect_db() {
        echo 'oracle connect to db server ...';
    }
}


$dbObj = new dbFactory();
$mysql = $dbObj->getDb('mysql');
$mysql->connect_db();