<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/19
 * Time: 00:07
 * 桥接模式
 * 桥接模式完全是为了解决继承的缺点而提出的设计模式。
 * 在该模式下，实现可以不受抽象的约束，不用再绑定在一个固定的抽象层次上。
 * 意图:将抽象部分与实现部分分离，使它们都可以独立的变化。
 */

abstract class staff{
    abstract public function staffData();
}

class commonStaff extends staff{
    public function staffData() {
        return 'a,b,c';
    }
}

class vimStaff extends staff{
    public function staffData() {
        return 'x,y,z';
    }
}


abstract class sendType{
    abstract public function send($to,$content);
}


class qq extends sendType{
    public function send($to, $content) {
        return $content.'(To)'.$to.' From QQ';
    }
}

class sendInfo{
    private $level;
    private $method;
    public function __construct($level,$method) {
        $this->level = $level;
        $this->method = $method;
    }

    public function sending($content){
        $staffArr = $this->level->staffData();
        $res = $this->method->send($staffArr,$content);
        echo $res;
    }
}

$info = new SendInfo(new vimStaff(), new qq());
$info->sending( 'go home');

$info = new SendInfo(new commonStaff(), new qq());
$info->sending( 'go work');