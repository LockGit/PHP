<?php
//引入模板inc文件
require 'includes/init.inc.php';
global $_tpl;

$test=new TestAction($_tpl);
$test->_action();


$_tpl->assign('name','Lock');
$_tpl->display('test.tpl');