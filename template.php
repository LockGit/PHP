<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 16:05
 * 模板方法模式
 * 模板方法模式又叫模板模式，该模式在一个方法中定义一个算法的骨架，而将一些步骤延迟到子类中。
 * 模板方法使得子类可以在不改变算法结构的情况下，重新定义算法中的某些步骤。
 */
//抽象模板类
abstract class MakePhone {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function MakeFlow() {
        $this->MakeBattery();
        $this->MakeCamera();
        $this->MakeScreen();
        echo $this->name . "手机生产完毕！" . PHP_EOL;
    }

    public abstract function MakeScreen();

    public abstract function MakeBattery();

    public abstract function MakeCamera();
}

//小米手机
class XiaoMi extends MakePhone {
    public function __construct($name = '小米') {
        parent::__construct($name);
    }

    public function MakeBattery() {
        echo "小米电池生产完毕！" . PHP_EOL;
    }

    public function MakeCamera() {
        echo "小米相机生产完毕！" . PHP_EOL;
    }

    public function MakeScreen() {
        echo "小米屏幕生产完毕！" . PHP_EOL;
    }
}

//魅族手机
class FlyMe extends MakePhone {
    function __construct($name = '魅族') {
        parent::__construct($name);
    }

    public function MakeBattery() {
        echo "魅族电池生产完毕！" . PHP_EOL;
    }

    public function MakeCamera() {
        echo "魅族相机生产完毕！" . PHP_EOL;
    }

    public function MakeScreen() {
        echo "魅族屏幕生产完毕！" . PHP_EOL;
    }
}

$miui = new XiaoMi();
$flyMe = new FlyMe();

$miui->MakeFlow();
$flyMe->MakeFlow();