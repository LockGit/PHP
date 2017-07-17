<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/17
 * Time: 14:31
 * 单例模式
 */


class db{
    private function __construct()
    {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public static function instance(){
        static $obj;
        if(empty($obj)) {
            $obj = new self();
        }
        return $obj;
    }

    public function work(){
        echo 'some thing...';
    }
}

db::instance()->work();