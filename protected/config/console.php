<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'My Console Application',

	'import' => array(
		'application.modules.itemsSetting.models.*',
		'application.modules.itemsCustomers.models.*',
		'application.modules.itemsUsers.models.*',

		'application.extensions.crontab.*',
	),

	'preload'=>array('log'),

	// application components
	'components' => array(

		// database settings are configured in database.php
		'db' => array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=c10nhakhoa2000',
			'emulatePrepare' => true,
			'username' => 'c10nhakhoa2000',
			'password' => 'dgmFRw2eZdFQ#',
			'charset' => 'utf8',
		),

		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => FALSE,
			'rules' => array(),
		),

		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
					'except' => 'crontab'
				),
				array(
					'class' => 'CFileLogRoute',
					'logFile' => 'crontab'.date('Ymd').'.log',
					'categories' => 'crontab'
				),
			),
		),
	),
);
