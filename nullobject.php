<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/13
 * Time: 23:46
 * 空对象模式
 * 简化客户端代码
 * 减少空指针异常风险
 * 更少的条件控制语句以减少测试用例
 */
interface LoggerInterface {
    public function log($str);
}

class Service {
    protected $logger;

    public function __construct(LoggerInterface $log) {
        $this->logger = $log;
    }

    public function doSomething() {
        $this->logger->log('we are in ' . __METHOD__);
    }
}

class PrintLogger implements LoggerInterface {
    public function log($str) {
        echo $str;
    }
}

class NullLogger implements LoggerInterface {
    public function log($str) {
        // do nothing
    }
}

$service = new Service(new PrintLogger());
$service->doSomething();

$service2 = new Service(new NullLogger());
$service2->doSomething();