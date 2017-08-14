<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/13
 * Time: 23:34
 * 备忘录模式
 * 又叫快照模式（Snapshot）或 Token 模式
 * 备忘录模式的用意是在不破坏封装性的前提下，捕获一个对象的内部状态。
 * 并在该对象之外保存这个状态，这样就可以在合适的时候将该对象恢复到原先保存的状态。
 */

/**
 * 备忘录
 * Class Memento
 */
class Memento {
    private $state;

    public function __construct($stateToSave) {
        $this->state = $stateToSave;
    }

    public function getState() {
        return $this->state;
    }
}


/**
 * 发起人
 * Class originator
 */
class originator {
    private $state;

    public function setState($state){
        $this->state = $state;
    }

    public function getStateAsMemento() {
        $state = is_object($this->state) ? clone $this->state : $this->state;
        return new Memento($state);
    }

    public function restoreFromMemento(Memento $memento) {
        $this->state = $memento->getState();
    }

}

/**
 * 管理角色
 */
class Caretaker{
    protected $history = [];

    public function getFromHistory($id) {
        return $this->history[$id];
    }

    public function saveToHistory(Memento $state) {
        $this->history[] = $state;
    }

    public function runCustomLogic() {
        $originator = new Originator();

        //设置状态为State1
        $originator->setState("State1");
        //设置状态为State2
        $originator->setState("State2");
        //将State2保存到Memento
        $this->saveToHistory($originator->getStateAsMemento());
        //设置状态为State3
        $originator->setState("State3");

        //我们可以请求多个备忘录, 然后选择其中一个进行回滚

        //保存State3到Memento
        $this->saveToHistory($originator->getStateAsMemento());
        //设置状态为State4
        $originator->setState("State4");

        $originator->restoreFromMemento($this->getFromHistory(1));
        //从备忘录恢复后的状态: State3

        return $originator->getStateAsMemento()->getState();
    }
}

$obj = new Caretaker();
$ret = $obj->runCustomLogic();
var_export($ret);