<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/2/26
 * Time: 12:51
 */

// 相对调用前台的cache.inc.php文件
// 已放入config文件夹下的profile.inc.php文件中控制
//是否开启缓冲区
define('IS_CACHE',true);
//判断是否开启缓冲区
IS_CACHE ? ob_start() : null;