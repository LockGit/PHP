<?php
/**
 * @Author: lock
 * @Date:   2017-02-14 09:32:15
 * @Last Modified by:   lock
 * @Last Modified time: 2017-02-14 09:32:28
 */
//抽象享元角色
interface Flyweight{
     function show();
}
//共享的具体享元角色
class ConcreteFlyweight implements Flyweight{
    private $state;
    function __construct($state){
        $this->state = $state;
    }
    function show(){
        return $this->state;
    }
}
//不共享的具体享元角色，客户端直接调用
class UnsharedConcreteFlyweight implements Flyweight{
    private $state;
    function __construct($state){
        $this->state = $state;
    }
    function show(){
        return $this->state;
    }
}
//享元工厂模式
class FlyweightFactory{
    private $flyweights = array();
    function getFlyweight($state){
        if(!isset($this->flyweights[$state])){
            $this->flyweights[$state]=new ConcreteFlyweight($state);
        }
        return $this->flyweights[$state];
    }
}

//测试
$flyweightFactory = new FlyweightFactory();
$flyweightOne = $flyweightFactory->getFlyweight("state A");
echo $flyweightOne->show();
$flyweightTwo = new UnsharedConcreteFlyweight("state B");
echo $flyweightTwo->show();
/*
state A
state B
*/