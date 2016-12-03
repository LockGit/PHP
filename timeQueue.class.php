<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2016/11/27
 * Time: 22:25
 */


class timeQueue
{
    private $redis;
    private $task = array();
    private $key;

    /**
     * timeQueue constructor.
     */
    public function __construct(){
        $conn = new \Redis();
        $conn->connect('127.0.0.1', 6379);
        $this->redis = $conn;
    }

    /**
     * 添加一个任务:任务名,什么时候执行,参数array
     * @param $name
     * @param $args
     * @param $time
     */
    public function add_task($name,$args,$time) {
        $this->key = $name;
        $saveData = array('name'=>$name,'args'=>$args);
        $members = json_encode($saveData);
        $this->redis->zAdd($this->key,time()+$time,$members);
    }

    /**
     * 监听某个任务:任务名,执行该任务的函数
     * @param $eventName
     * @param $func
     * @return bool
     */
    public function listen_task($eventName, $func){
        if(in_array($eventName,$this->task)){
            return false;
        }
        $this->task[$eventName]=$func;
    }

    /**
     * 移除一个存在的任务
     * @param $eventName
     */
    public function remove_task($eventName){
        if(in_array($eventName,array_keys($this->task))){
            unset($this->task[$eventName]);
        }
    }

    /**
     * 运行
     */
    public function run(){
        while (true) {
            $result = $this->redis->zRange($this->key, 0, 0, true);
            if (count($result) == 0){
                usleep(500);
                continue;
            }
            $scoreArr = array_values($result);
            if($scoreArr[0]>time()){
                usleep(500);
                continue;
            }
            $itemArr = array_keys($result);
            $v = $this->redis->zRem($this->key, $itemArr[0]);
            if($v==false){
                continue;
            }
            $data = json_decode($itemArr[0],1);
            if(in_array($data['name'],array_keys($this->task))){
                $this->task[$data['name']]($data['args']);
            }
        }
    }

}

$obj = new timeQueue();
//添加任务并制定多少秒之后执行
$obj->add_task('test',[1,2],3);
$obj->add_task('demo',[1,2],2);
$obj->add_task('bug',[1,2],12);
$obj->add_task('test',[3,4],1);
$obj->add_task('test',[5,6],8);
//回调函数
$func = function ($args){
    var_dump($args);
};
//设置需要监听的任务
$obj->listen_task('test',$func);
$obj->listen_task('demo',$func);
//移除一个已经注册了的任务
$obj->remove_task('bug');
$obj->run();

