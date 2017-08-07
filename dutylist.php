<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/7
 * Time: 23:35
 * 责任链模式（职责链）
 * 责任链模式是一种对象的行为模式，在责任链模式里，很多对象由每一个对象对其下家的引用而连接起来形成一条链。
 * 请求在这个链上传递，直到链上的某一个对象决定处理此请求。
 * 发出这个请求的客户端并不知道链上的哪一个对象最终处理这个请求，这使得系统可以在不影响客户端的情况下动态的重新组织和分配责任。
 */

/**
 * 抽象处理者角色
 * Class Handle
 */
abstract class Handle {
    protected $successor;

    abstract public function handleRequest();

    public function getSuccessor() {
        return $this->successor;
    }

    public function setSuccessor($successorObj) {
        $this->successor = $successorObj;
    }
}


/**
 * 具体处理者角色
 * Class HandleRole
 */
class HandleRole extends Handle {
    public function handleRequest() {
        if ($this->successor !== null) {
            echo "放过请求，将请求转发给后继的责任对象!" . PHP_EOL;
            $this->getSuccessor()->handleRequest();
        } else {
            echo "处理请求，处理过程省略..." . PHP_EOL;
        }
    }

}

$handleOne = new HandleRole();
$handleTwo = new HandleRole();
$handleOne->setSuccessor($handleTwo);

$handleOne->handleRequest();