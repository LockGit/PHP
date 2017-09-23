<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/2/26
 * Time: 12:54
 */

//数据库配置文件
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','test');

define('TPL_DIR',ROOT_PATH.'/templates/');
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');
define('CONFIG_FILE',ROOT_PATH.'/config/config.xml');
define('INC_DIR',ROOT_PATH.'/includes/');
define('CACHE',ROOT_PATH.'/cache/');
//系统配置文件
define('WEBNAME','a initFrame for php');
define('GPC',get_magic_quotes_gpc());