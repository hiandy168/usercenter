<?php

define('LOG_DIR', realpath(dirname(__FILE__) . '/../runtime'));
return array(
		'class'=>'CLogRouter',
		'routes'=>array(
	      array(
			'class'=>'CFileLogRoute',
			//'levels'=>'warning,error',       //日志级别, 如:info  不填写，表示全部
			//'categories'=>'',                //日志分类，如：application.componets 不填写，表示全部类别
			'LogDir'=>LOG_DIR,
	      	'filter'=>'CLogFilter',
			'logFileName'=>'error.log'
			),
// 			array(
// 				'class'=>'CWebLogRoute',
// 				'filter'=>'CLogFilter',
// 			),
// 			array(
// 				'class'=>'CProfileLogRoute',
// 				'levels' => CLogger::LEVEL_PROFILE,
// 				'showInFireBug' => true,
// 				'ignoreAjaxInFireBug' => true,
// 				'categories' => 'system.db.* ', //只记录db的操作日志，其他的忽略
// 			),
// 			array(
// 					'class'=>'XWebDebugRouter',
// 					'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
// 					'levels'=>'error, warning, trace, profile, info',
// 					//'categories'=>'vardump',
// 					//'allowedIPs'=>array('127.0.0.1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
// 			),
		)




//    'class' => 'CLogRouter',
//    'routes' => array(
//        array(
//            'class' => 'CFileLogRoute',
//            'levels' => 'error,warning',
//        ),
//        array(
//            'class' => 'CWebLogRoute',
//            'levels' => 'trace, info, error, warning, xdebug',
//            'categories' => 'system.db.*'
//        ),
//    ),
);
