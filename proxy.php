<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/6
 * Time: 01:34
 * 代理模式
 * 为其他对象提供一种代理以控制对这个对象的访问。
 */
class Printer {
    //代理对象,一台打印机
    public function printSth($args) {
        echo $args[0].', I can print'.PHP_EOL;
    }
}

class TextShop {
    //这是一个文印处理店,只文印,卖纸,不照相
    private $printer;

    public function __construct(Printer $printer) {
        $this->printer = $printer;
    }

    public function sellPaper() {
        //卖纸
        echo 'give you some paper ';
    }

    public function __call($method, $args) {
        //将代理对象有的功能交给代理对象处理
        if (method_exists($this->printer, $method)) {
            $this->printer->$method($args);
        }
    }
}

class PhotoShop {
    //这是一个照相店,只文印,拍照,不卖纸
    private $printer;

    public function __construct(Printer $printer) {
        $this->printer = $printer;
    }

    public function takePhotos() {    //照相
        echo 'take photos for you ';
    }

    public function __call($method, $args) {
        //将代理对象有的功能交给代理对象处理
        if (method_exists($this->printer, $method)) {
            $this->printer->$method($args);
        }
    }
}

$printer = new Printer();
$textShop = new TextShop($printer);
$photoShop = new PhotoShop($printer);

$textShop->printSth('textShop');
$photoShop->printSth('photoShop');