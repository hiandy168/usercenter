<?php
//error_reporting(0);
//调试环境，打开trace
define('MOD_DEBUG', true);
ini_set("max_execution_time", 30);
//加载配置文件和Mod框架
$config = dirname(__FILE__).'/protected/config/main.conf.php';

// 定义根目录
define("ROOT_DIR", dirname(__FILE__));
// 创建环境配置对象
// 创建一个Web应用实例并执行
require(dirname(__FILE__).'/framework/Mod.php');

//定义活动城市日历活动地址
define('CITY_CALENDAR_URL', 'http://weiqin.dachuw.net/app/index.php?i=1&c=entry&do=redirect&m=cg_hongbao&redirecturl=');//q签到


//����Mod���
$app = Mod::createWebApplication($config);
define('HOSTNAME', Mod::app()->createAbsoluteUrl('/')  );
$app->run();


//
//// 定义根目录
////define('MOD_DEBUG', true);
//define("ROOT_DIR", dirname(__FILE__));
//require(ROOT_DIR . "/protected/components/Environment.php");
//// 创建环境配置对象
//$env = new Environment(null, array('life_time'=>30));
//// 设置输出编码，效果同php.ini中配置default_charset
//header('Content-type:text/html;charset='.$env->get('charset'));
//// 创建一个Web应用实例并执行
////defined('MOD_ENABLE_EXCEPTION_HANDLER') or define('MOD_ENABLE_EXCEPTION_HANDLER',false);  
////defined('MOD_ENABLE_ERROR_HANDLER') or define('MOD_ENABLE_ERROR_HANDLER',false);  
//require($env->getModPath().'/Mod.php');
//Mod::createWebApplication($env->getConfig())->run();
