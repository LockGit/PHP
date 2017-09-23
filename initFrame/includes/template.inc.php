<?php
/**
 * @Author: Lock
 * @Date:   2014-11-25 23:50:30
 * @Last Modified by:   Lock
 * @Last Modified time: 2014-11-26 00:05:19
 */
header('Content-type:text/html;charset=utf-8');
//定义网站根目录
define('ROOT_PATH',dirname(dirname(__FILE__)));
// 模板文件目录
define('TPL_DIR',ROOT_PATH.'/templates/');
// 模板编译文件目录
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');
//定义xml配置文件
define('CONFIG_FILE',ROOT_PATH.'/config/config.xml');
//定义includes类的文件夹
define('INC_DIR',ROOT_PATH.'/includes/');
// 静态html缓存文件目录
define('CACHE',ROOT_PATH.'/cache/');

//是否开启缓冲区
define('IS_CACHE',true);
//判断是否开启缓冲区
IS_CACHE ? ob_start() : null;

// 引入模板文件

require INC_DIR.'Template.class.php';

$_tpl=new Template();

?>