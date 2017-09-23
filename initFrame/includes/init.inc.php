<?php
/**
 * @Author: Lock.Esc
 * @Date:   2014-11-25 23:50:30
 * @Last Modified by:   Lock
 * @Last Modified time: 2015-01-18 21:14:38
 */
// 开启session
session_start();
// 设置时区
date_default_timezone_set('Asia/Shanghai');
header('Content-type:text/html;charset=utf-8');
//定义网站根目录
define('ROOT_PATH',dirname(dirname(__FILE__)));
// 引入profile.inc.php
require_once ROOT_PATH.'/config/profile.inc.php';
// // 引入数据库配置文件
// require_once ROOT_PATH.'/includes/DB.class.php';
// // 引入工具类
// require_once ROOT_PATH.'/includes/Tool.class.php';

// autoload自动加载需要的类
// 引入model下的manage类
// require_once ROOT_PATH.'/model/Model.class.php';
// require_once ROOT_PATH.'/model/Manage.class.php';
// // 引入业务流程类（Action）
// require_once ROOT_PATH.'/action/Action.class.php';
// require_once ROOT_PATH.'/action/ManageAction.class.php';
function __autoload($classname){
    if(substr($classname, -6)=='Action'){
        require_once ROOT_PATH.'/action/'.$classname.'.class.php';
    }elseif(substr($classname, -5)=='Model'){
        require_once ROOT_PATH.'/model/'.$classname.'.class.php';
    }else{
        require_once ROOT_PATH.'/includes/'.$classname.'.class.php';
    }
}

// 按照访问的是前台还是后台目录相对位置引入cache.inc.php文件，是否开启缓存
require_once 'cache.inc.php';

//禁用错误报告
// 忽略非标准规范及Notice之外的所有错误
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);

//$_cache = new Cache(array('code','ckeup','static','upload','feedback','cast','friendlink','search')); 	// 设置不缓存页面
// 引入模板文件
// require INC_DIR.'Template.class.php';

$_tpl=new Template();
//前台初始化
//require_once 'common.inc.php';