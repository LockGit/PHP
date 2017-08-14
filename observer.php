<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 14:50
 * 观察者模式
 * 对象的一对多依赖,这样一来，当一个对象改变状态时，它的所有依赖者都会收到通知并自动更新!
 */

class Paper{
    private $observer = [];

    /**
     * 注册观察者
     * @param $sub
     */
    public function register($sub){
        $this->observer[]=$sub;
    }

    /**
     *  外部统一访问
     */
    public function trigger(){
        if(!empty($this->observer)){
            foreach ($this->observer as $obj){
                $obj->update();
            }
        }
    }
}

/**
 * 观察者要实现的接口
 */
interface Observerable{
    public function update();
}

class Sub implements Observerable{
    public function update(){
        echo 'Sub execute update...'.PHP_EOL;
    }
}

class People implements Observerable{
    public function update() {
        echo 'People execute update...'.PHP_EOL;
    }
}

$paperObj = new Paper();
$paperObj->register(new Sub());
$paperObj->register(new People());
$paperObj->trigger();