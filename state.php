<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 15:26
 * 状态模式
 * 状态模式当一个对象的内在状态改变时允许改变其行为，这个对象看起来像是改变了其类。
 * 状态模式主要解决的是当控制一个对象状态的条件表达式过于复杂时的情况。把状态的判断逻辑转移到表示不同状态的一系列类中，可以把复杂的判断逻辑简化。
 */
//状态接口
interface IState {
    public function WriteCode(Work $w);
}

//工作状态
class Work {
    private $current;
    public $hour;
    public $isDone;

    public function Work() {
        $this->current = new AmState();
    }

    public function SetState(IState $s) {
        $this->current = $s;
    }

    public function WriteCode() {
        $this->current->WriteCode($this);
    }
}

//上午工作状态
class AmState implements IState {
    public function WriteCode(Work $w) {
        if ($w->hour <= 12) {
            echo "当前时间：{$w->hour}点，上午工作；犯困，午休。" . PHP_EOL;
        } else {
            $w->SetState(new PmState());
            $w->WriteCode();
        }
    }
}

//下午工作状态
class PmState implements IState {
    public function WriteCode(Work $w) {
        if ($w->hour <= 17) {
            echo "当前时间：{$w->hour}点，下午工作状态还不错，继续努力。" . PHP_EOL;
        } else {
            $w->SetState(new NightState());
            $w->WriteCode();
        }
    }
}

//晚上工作状态
class NightState implements IState {

    public function WriteCode(Work $w) {
        if ($w->IsDone) {
            $w->SetState(new BreakState());
            $w->WriteCode();
        } else {
            if ($w->hour <= 21) {
                echo "当前时间：{$w->hour}点，加班哦，疲累至极。" . PHP_EOL;
            } else {
                $w->SetState(new SleepState());
                $w->WriteCode();
            }
        }
    }
}

//睡眠状态
class SleepState implements IState {

    public function WriteCode(Work $w) {
        echo "当前时间：{$w->hour}点，不行了，睡着了。" . PHP_EOL;
    }
}

//休息状态
class BreakState implements IState {

    public function WriteCode(Work $w) {
        echo "当前时间：{$w->hour}点，下班回家了。" . PHP_EOL;
    }
}

$emergWork = new Work();
$emergWork->hour = 9;
$emergWork->WriteCode();
$emergWork->hour = 10;
$emergWork->WriteCode();
$emergWork->hour = 13;
$emergWork->WriteCode();
$emergWork->hour = 14;
$emergWork->WriteCode();
$emergWork->hour = 17;
$emergWork->WriteCode();
$emergWork->IsDone = false;
$emergWork->hour = 19;
$emergWork->WriteCode();
$emergWork->hour = 22;
$emergWork->WriteCode();