<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/6
 * Time: 00:33
 * 外观模式（门面模式）
 * 用于为子系统中的一组接口提供一个一致的界面。门面模式定义了一个高层接口，这个接口使得子系统更加容易使用。
 * 引入门面角色之后，用户只需要直接与门面角色交互，用户与子系统之间的复杂关系由门面角色来实现，从而降低了系统的耦合度。
 */

class Os{
    public function halt(){
        echo 'I will halt'.PHP_EOL;
    }
}


class Bios{
    public function execute(){
        echo 'execute code...'.PHP_EOL;
    }

    public function waitForKeyPress(){
        echo 'waiting key press...'.PHP_EOL;
    }

    public function launch(){
        echo 'launch process...'.PHP_EOL;
    }

    public function powerDown(){
        echo 'shutdown system...'.PHP_EOL;
    }
}


class Facade{
    protected $os;
    protected $bios;

    public function __construct(Bios $bios,Os $os) {
        $this->os = $os;
        $this->bios = $bios;
    }

    /**
     * turn on system
     */
    public function turnOn(){
        $this->bios->execute();
        $this->bios->waitForKeyPress();
        $this->bios->launch();
    }

    /**
     * shutdown system
     */
    public function turnOff(){
        $this->os->halt();
        $this->bios->powerDown();
    }
}

$obj = new Facade(new Bios(),new Os());
$obj->turnOn();
$obj->turnOff();