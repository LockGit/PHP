<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/18
 * Time: 18:22
 * 适配器模式
 * 适配器模式使得原本由于接口不兼容而不能一起工作的那些类可以在一起工作。
 */


interface target{
    public function copy();
    public function move();
}

class iterm {
    public function copy(){
        echo 'can copy text...';
    }
}
class tool implements target{
    private $iterm;
    public function __construct(iterm $iterm) {
        $this->iterm = $iterm;
    }

    public function copy() {
        $this->iterm->copy();
    }

    public function move() {
        echo 'can move text...';
    }

}

$iterm = new iterm();
$tool = new tool($iterm);
$tool->copy();
$tool->move();
