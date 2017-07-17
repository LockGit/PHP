<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/17
 * Time: 10:23
 * 对象池模式
 * 对象池可以用于构造并且存放一系列的对象并在需要时获取调用
 */
class Product {

    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}

class Factory {

    protected static $products = array();

    public static function pushProduct(Product $product) {
        self::$products[$product->getId()] = $product;
    }

    public static function getProduct($id) {
        return isset(self::$products[$id]) ? self::$products[$id] : null;
    }

    public static function removeProduct($id) {
        if (array_key_exists($id, self::$products)) {
            unset(self::$products[$id]);
        }
    }
}


Factory::pushProduct(new Product('first'));
Factory::pushProduct(new Product('second'));

print_r(Factory::getProduct('first')->getId());
print_r(Factory::getProduct('second')->getId());