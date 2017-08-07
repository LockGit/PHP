<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/8
 * Time: 00:06
 * 命令行模式
 * 将请求封装成对象，从而使你可用不同的请求对客户进行参数化；对请求排队或记录请求日志，以及支持可撤消的操作。
 */

/**
 * 命令行接口
 * Interface Command
 */
interface Command {
    public function execute();
}

/**
 * 接收调用请求的类
 * Class Receiver
 */
class Receiver {
    public function write($str) {
        echo $str;
    }
}


/**
 * Class HelloCommand
 */
class HelloCommand implements Command {
    protected $output;

    public function __construct(Receiver $console) {
        $this->output = $console;
    }

    public function execute() {
        $this->output->write('hello world');
    }
}

/**
 * 调用者
 * Class Invoker
 */
class Invoker {
    protected $command;

    public function setCommand(Command $cmd) {
        $this->command = $cmd;
    }

    /**
     * @return mixed
     */
    public function run() {
        $this->command->execute();
    }
}


$invokeObj = new Invoker();
$receiverObj = new Receiver();
$invokeObj->setCommand(new HelloCommand($receiverObj));
$invokeObj->run();