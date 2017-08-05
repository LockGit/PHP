<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/6
 * Time: 01:42
 * 注册模式
 * 也叫做注册树模式，注册器模式。
 * 为应用中经常使用的对象创建一个中央存储器来存放这些对象 —— 通常通过一个只包含静态方法的抽象类来实现（或者通过单例模式）。
 */
class Register {
    protected static $storage = [];

    public static function set($key, $val) {
        self::$storage[$key] = $val;
    }

    public static function get($key) {
        return self::$storage[$key];
    }

}

Register::set('name','lock');
echo Register::get('name');