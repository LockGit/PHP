<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/16
 * Time: 00:08
 * 工厂方法模式
 * 定义一个创建对象的接口，
 * 但是让子类去实例化具体类。工厂方法模式让类的实例化延迟到子类中。
 */



interface calcFactory{
    public function createOperate();
}


class addFactory implements calcFactory{
    public function createOperate() {
        return new addOperate();
    }
}

class subFactory implements calcFactory{
    public function createOperate() {
        return new subOperate();
    }
}


/**
 * 加法
 * Class addOperate
 */
class addOperate extends operate{
    public function getRes() {
        return $this->a + $this->b;
    }
}

/**
 * 减法
 * Class subOperate
 */
class subOperate extends operate{
    public function getRes(){
        return $this->a - $this->b;
    }
}

/**
 * 操作类
 * Class operate
 */
abstract class operate{
    public $a;
    public $b;
    public function setA($num){
        $this->a = $num;
    }

    public function getA(){
        $this->a;
    }

    public function setB($num){
        $this->b=$num;
    }

    public function getB(){
        $this->b;
    }

    abstract public function getRes();
}

/**
 * Class Client
 */
class Client{
    public static function start(){
        $add = new addFactory();
        $addObj = $add->createOperate();
        $addObj->setA(10);
        $addObj->setB(12);
        echo $addObj->getRes();

        echo PHP_EOL;

        $sub = new subFactory();
        $subObj = $sub->createOperate();
        $subObj->setA(30);
        $subObj->setB(15);
        echo $subObj->getRes();
    }
}

Client::start();