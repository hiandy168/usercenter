<?php
// change the following paths if necessary
$mod=dirname(__FILE__).'/framework/Mod.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('MOD_DEBUG') or define('MOD_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('MOD_TRACE_LEVEL') or define('MOD_TRACE_LEVEL',3);
require_once($mod);
Mod::createWebApplication($config)->run();

