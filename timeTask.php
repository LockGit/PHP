<?php
class timeTask{
    private $task = array();
    private $key;
    private $event = array();

    public static function instance(){
        static $obj;
        if(empty($obj)){
            $obj = new self();
        }
        return $obj;
    }

    //添加任务
    public function add_event($task,$args,$timeout){
        //index第几圈以后进行task，second(0~3600)
        $index = floor($timeout/3600);
        $second = $timeout % 3600;
        $this->event[$second][$task]['index'] = $index;
        $this->event[$second][$task]['args'] = $args;
    }

    //监听任务
    public function listen_task($eventName, $func){
        if(in_array($eventName,$this->task)){
            return false;
        }
        $this->task[$eventName]=$func;
    }

    //移除任务
    public function remove_task($eventName){
        if(in_array($eventName, array_keys($this->task))){
            unset($this->task[$eventName]);
        }
    }

    public function run(){
        while (1) {
            for($second=0;$second<3600;$second++){
                sleep(1);
                if(isset($this->event[$second]) && is_array($this->event[$second])){
                    foreach ($this->event[$second] as $func => $val_arr) {
                        foreach ($val_arr as $key => $val) {
                            if($key=='index' && $val<=0){
                                //执行task，如果task耗时，可以在推到另一个队列消耗
                                if(in_array($func, array_keys($this->task))){
                                    $this->task[$func]($this->event[$second][$func]['args']);
                                    unset($this->event[$second][$func]);
                                }
                            }else{
                                if(in_array($func, array_keys($this->task)) && isset($this->event[$second][$func])){
                                    $this->event[$second][$func]['index'] = $this->event[$second][$func]['index']-1; 
                                }
                            }
                        }
                    } 
                }
            }
        }
    }

}

//参数分别为：所执行的task,参数,延迟的时间
timeTask::instance()->add_event('lock',[1,2,1],1);
timeTask::instance()->add_event('root',[8,9,1],1);
timeTask::instance()->add_event('test',[3,4,3],3);
timeTask::instance()->add_event('test',[7,8,10],10);
//设置回调函数
$func = function($args){
    echo date('Y-m-d H:i:s').",当前正在执行第".$args[2]."s任务...\n";
    var_export($args);
    echo "\n\n";
};
timeTask::instance()->listen_task('test',$func);
timeTask::instance()->listen_task('lock',$func);
timeTask::instance()->listen_task('root',$func);
#移除一个已经注册的任务
timeTask::instance()->remove_task('root');

timeTask::instance()->run();


// ➜  ~ php timeTask.php
// 2017-03-24 09:19:02,当前正在执行第1s任务...
// array (
//   0 => 1,
//   1 => 2,
//   2 => 1,
// )

// 2017-03-24 09:19:04,当前正在执行第3s任务...
// array (
//   0 => 3,
//   1 => 4,
//   2 => 3,
// )

// 2017-03-24 09:19:11,当前正在执行第10s任务...
// array (
//   0 => 7,
//   1 => 8,
//   2 => 10,
// )





