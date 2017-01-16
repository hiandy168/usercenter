<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL & ~ E_NOTICE);
// 定义目录
define("ROOT_DIR", dirname(__FILE__));
define('FRAMEWORK_PATH', '/data/php/framework/');
 
// 加载
$config=dirname(__FILE__).'/protected/config/main.php';
require (FRAMEWORK_PATH . "Mod.php"); // 加载 海豹框架
                                 

Mod::createWebApplication($config)->run();