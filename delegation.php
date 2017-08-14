<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 16:45
 * 委托模式
 * 委托是对一个类的功能进行扩展和复用的方法。
 * 它的做法是：写一个附加的类提供附加的功能，并使用原来的类的实例提供原有的功能。
 */
class Bank {
    protected $info;

    /**
     * @param $type
     * @param $money
     */
    public function updateBrankInfo($type, $money) {
        $this->info[$type] = $money;
    }

    /**
     * 相关操作（包括存款、取款操作）
     * @param $branktype
     * @return mixed
     */
    public function brankWithdraw($branktype) {
        $obj = new $branktype;
        return $obj->brankMain($this->info);
    }
}

/**
 * 委托接口
 * Interface Delegate
 */
interface Delegate {
    public function brankMain($info);
}

/**
 * 存款操作类
 * Class brankDeposit
 */
class brankDeposit implements Delegate {
    /**
     * 存款操作
     * @param $info
     */
    public function brankMain($info) {
        echo $info['deposit'];
    }
}

/**
 * 取款操作类
 * Class brankWithdraw
 */
class brankWithdraw implements Delegate {
    /**
     * 取款操作
     * @param $info
     */
    public function brankMain($info) {
        echo $info['withdraw'];
    }
}

/*
客户端测试代码：
*/
$bank = new Bank();
$bank->updateBrankInfo("deposit", "4000");
$bank->updateBrankInfo("withdraw", "2000");
$bank->brankWithdraw("brankDeposit");
echo PHP_EOL;
$bank->brankWithdraw("brankWithdraw");