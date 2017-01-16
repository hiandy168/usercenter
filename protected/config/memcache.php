<?php
/**
 * memcache配置
*/

$configDev = array(
	'class'=>'CMemCache',
	'useMemcached'=>false,

	'servers'=>array(array(
        'host'=>'127.0.0.1',
        'port'=>11211,
        'weight'=>100,
        'persistent'=>true
        )),
	//	'enablePerformReport'=>true,
);


return $configDev;
