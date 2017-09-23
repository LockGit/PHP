### initFrame 一个php框架
```
自学php的时候在网上翻阅了大量资料,参考前人的思想最终形成的一个低级别的php框架，有很多实现不合理的地方，跟现有的流行框架没法比，
仅当做学习使用。后来想了下，应该叫模板引擎更为合理吧? 这个代码已经很老了,push上来，作为学习过程的一个记录吧。

关于框架的执行流程：
在WooYun还没有关闭前我提交了最后一个ThinkPHP框架漏洞，ThinkPHP官方在1~2天内便修复了，WooYun关闭以后发现文
章已经找不到了。在此之前就已经有人对ci，yii之类的frame做过分析，那篇文章详细分析了漏洞的成因也详细叙述了框架的大致执行过程，
我认为思想适用于所有框架。99%的PHP框架都是MVC吧.~~~~

initFrame实现了那些功能？
1,非常简单的MVC
2,自解析的模板引擎(自解析：变量，数组，if，for，注释，等模板语法)
3,支持缓存
```

```
view加载模板文件过程
核心解析类文件有(实现了模板引擎的功能)：
	initFrame/includes/Parse.class.php
	initFrame/includes/Template.class.php

1,首先通过解析类解析tpl模板文件,其实就是通过一系列的正则匹配替换tpl文件中的一些定义字符为php语法,生成可执行的php文件,这里
叫做编译文件

2,编译文件生成后,也就是纯php文件，php解析器开始解析这个纯php文件并生成纯静态文件(当缓存开启)

3,当修改了index.tpl模板文件,程序会把index.tpl文件的最后修改时间(t1)与index.tpl.php文件的最后修改时间(t2)进行比较，
当t1>t2,那么重新生成index.tpl.php文件和index.tpl.html文件

4,如果开启了缓存，那么直接加载缓存后的html文件，即cache目录中的静态文件

执行过程图：
```
![](https://github.com/LockGit/initFrame/blob/master/doc/initFrame.png)

### 测试
```
-------start------
//引入模板inc文件
require 'includes/template.inc.php';
global $_tpl;
// $_tpl->assign('name','lock');
// $_tpl->display('index.tpl');
$arr=array(1,2,3,4,5,6,7);

// 赋值单一变量
$_tpl->assign('name','Lock');
$_tpl->assign('num',5<4);
// 赋值一个数组
$_tpl->assign('arr',$arr);
$_tpl->display('index.tpl');
-------end------

cd initFrame && php -S 0:8888

访问：http://127.0.0.1:8888/index.php
```
```
响应:
index.tpl文件

首页
音乐
歌曲
舞蹈
hello
由系统变量设置的分页:15

$name的值：Lock
设置if语句

No
设置Foreach语句

0 => 1 
1 => 2 
2 => 3 
3 => 4 
4 => 5 
5 => 6 
6 => 7 
文件引入:mmaaabbcc456123xzhes
```
```
访问：http://127.0.0.1:8888/test.php
响应:
test.tpl文件

test val is :hello world

name is: Lock

```