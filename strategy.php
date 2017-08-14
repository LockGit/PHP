<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 15:53
 * 策略模式
 * 实现某一个功能有多种算法或者策略，我们可以根据环境或者条件的不同选择不同的算法或者策略来完成该功能。
 * 定义了算法族,分别封装起来，让它们之间可以互相替换，此模式让算法的变化独立于使用算法的客户。
 */
interface FlyBehavior {
    public function fly();
}

class FlyWithWings implements FlyBehavior {
    public function fly() {
        echo "Fly With Wings \n";
    }
}

class FlyWithNo implements FlyBehavior {
    public function fly() {
        echo "Fly With No Wings \n";
    }
}

class Duck {
    private $_flyBehavior;

    public function performFly() {
        $this->_flyBehavior->fly();
    }

    public function setFlyBehavior(FlyBehavior $behavior) {
        $this->_flyBehavior = $behavior;
    }
}

class RubberDuck extends Duck {
}

// Test Case
$duck = new RubberDuck();

/*  想让鸭子用翅膀飞行 */
$duck->setFlyBehavior(new FlyWithWings());
$duck->performFly();

/*  想让鸭子不用翅膀飞行 */
$duck->setFlyBehavior(new FlyWithNo());
$duck->performFly();
