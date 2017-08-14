<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/13
 * Time: 22:57
 * 中介者模式
 * 用一个中介对象来封装一系列的对象交互,使各对象不需要显式地相互引用从而使其耦合松散,而且可以独立地改变它们之间的交互
 */
abstract class Mediator {
    abstract public function send($message, $colleague);
}

abstract class Colleague {
    private $_mediator = null;

    public function __construct($mediator) {
        $this->_mediator = $mediator;
    }

    public function send($message) {
        $this->_mediator->send($message, $this);
    }

    abstract public function notify($message);
}

class Colleague1 extends Colleague {
    public function notify($message) {
        echo "Colleague1 Message is :" . $message . PHP_EOL;
    }
}

class Colleague2 extends Colleague {
    public function notify($message) {
        echo "Colleague2 Message is :" . $message . PHP_EOL;
    }
}

class ConcreteMediator extends Mediator {
    private $_colleague1 = null;
    private $_colleague2 = null;

    public function send($message, $colleague) {
        if ($colleague == $this->_colleague1) {
            $this->_colleague1->notify($message);
        } else {
            $this->_colleague2->notify($message);
        }
    }

    public function set($colleague1, $colleague2) {
        $this->_colleague1 = $colleague1;
        $this->_colleague2 = $colleague2;
    }
}

//
$objMediator = new ConcreteMediator();
$objC1 = new Colleague1($objMediator);
$objC2 = new Colleague2($objMediator);
$objMediator->set($objC1, $objC2);
$objC1->send("to c2 from c1");
$objC2->send("to c1 from c2");