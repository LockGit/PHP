<?php
/**
 * @Author: Lock
 * @Date:   2014-11-25 23:27:22
 * @Last Modified by:   Lock
 * @Last Modified time: 2014-11-26 00:09:29
 */

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

?>