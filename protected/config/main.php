<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

chdir(dirname($_SERVER['SCRIPT_FILENAME']).'/conf');
if ($conf_file = file('conf.conf')) {
	$db_connect_values = array();
	foreach ($conf_file as $conf_file_option) {
		$conf_file_option = rtrim($conf_file_option);
		$conf_file_option_parts = explode(':', $conf_file_option);
		$db_connect_values[$conf_file_option_parts[0]] = $conf_file_option_parts[1];
	}
}

return array(
    'language'=>'ru',
    'defaultController' => 'face',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
            'showScriptName' => false,
			'urlFormat'=>'path',
			'rules'=>array(
                'control' => 'control',
                'install' => 'install',
                //'control/login' => 'control/login/index',
				'install/<action:\S+>'=>'install/<action>',
                'control/<action:\S+>'=>'control/<action>',
                //'<controller:\S+>' => '<controller>',
                //'<id:[a-zA-Z0-9\-_]+>'=>'face/ShowCatsOrProd',
                //'<id:[a-zA-Z0-9\-_]+>/<page:\d*>'=>'face/ShowCatsOrProd',
                '<id:.+>'=>'face/ShowCatsOrProd',
                //'<id_prod:\S+>'=>'test/ShowProduct',
				/*'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
			),
		),
		
		//'db'=>array(
			//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host='.$db_connect_values['db_host'].';dbname='.$db_connect_values['db_name'],
			'emulatePrepare' => true,
			'username' => $db_connect_values['db_user'],
			'password' => $db_connect_values['db_pass'],
			'charset' => 'utf8',
            'enableProfiling'=>true,
            'enableParamLogging' => true,
            //'schemaCachingDuration' => 0,
            
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                /*array(
                    'class' => 'CWebLogRoute',
                    //'categories' => 'application',
                    'levels'=>'trace',
                    'showInFireBug'=>true,  
                ),*/
                /*array(
                    'class'=>'ext.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),*/
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);