<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=111.47.243.43;dbname=dcshop',
	'emulatePrepare' => true,
	'username' => 'test',
	'password' => 'Test@2015',
	'charset' => 'utf8',
        'tablePrefix' => 'car_',
        'enableProfiling'=>true,
);