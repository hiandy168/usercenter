<?php
	return array(
		'urlFormat'=>'path',
		'rules'=>array(
			'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',//通用url规则
		),			
		'showScriptName'=>false,		
	);