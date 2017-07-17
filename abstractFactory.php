<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/14
 * Time: 17:48
 * 抽象工厂模式
 */

/*
 * 抽象工厂
 * 具体工厂
 * 抽象产品
 * 具体产品
 * 产品使用者
 */

/**
 * 抽象工厂
 * Class animalFactory
 */
abstract class animalFactory {
    abstract public function createDog();
    abstract public function createCat();
}


/**
 * 具体工厂
 * Class blackAnimalFactory
 */
class blackAnimalFactory extends animalFactory {
    public function createCat() {
        return new WhiteCat();
    }

    public function createDog() {
        return new BlackDog();
    }
}

/**
 * 具体工厂
 * Class whiteAnimalFactory
 */
class whiteAnimalFactory extends animalFactory{
    public function createCat() {
        return new WhiteCat();
    }

    public function createDog() {
        return new BlackDog();
    }
}


/**
 * 抽象产品
 * Class cat
 */
abstract class cat{
    abstract public function voice();
}

/**
 * 抽象产品
 * Class dog
 */
abstract class dog{
    abstract public function voice();
}


/**
 * Class WhiteCat
 * 具体产品
 */
class WhiteCat extends cat{
    public function voice() {
        echo 'White #fff cat voice....<br/>';
    }
}

/**
 * Class BlackDog
 * 具体产品
 */
class BlackDog extends dog{
    public function voice() {
        echo 'Black #000 dog voice....<br/>';
    }
}


/**
 * 抽象工厂模式为一组相关或相互依赖的对象创建提供接口，而无需指定其具体实现类。
 * 抽象工厂的客户端不关心如何创建这些对象，只关心如何将它们组合到一起。
 * Class Client
 */
class Client{
    public static function main(){
        self::run(new blackAnimalFactory());
        self::run(new whiteAnimalFactory());
    }

    private static function run(animalFactory $animalFactory){
        $cat = $animalFactory->createCat();
        $cat->voice();

        $dog = $animalFactory->createDog();
        $dog->voice();
    }
}

Client::main();

