<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Atmarkcafe',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*','ext.YiiMailer.YiiMailer'
    ),

	'modules'=>array(
        'wdcalendar'    => array(
            //'admin' => 'install'
        ),

        'meeting'    => array(
            //'admin' => 'install'
        ),
		// uncomment the following to enable the Gii tool
//        'theme'=>'bootstrap',
    /*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
    */
	),

	// application components
	'components'=>array(
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js'=>false,  //disable default implementation of jquery
            )
        ),
//        'sourceLanguage'=>'en',

		// uncomment the following to enable URLs in path-format

		'urlManager'    =>array(
			'urlFormat' =>'path',
			'rules'     => array(
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
            'rules' => array(
                'showScriptName' =>  false,
                'caseSensitive'  =>  false,
                'login'          =>  'site/login',
                'contact'        =>  'site/contact',
            )
		),

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host='.DB_SERVER.';dbname='.DB_NAME,
			'emulatePrepare' => true,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset' => 'utf8',
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
		'adminEmail'=>'htd530@gmail.com',
        'password' => '01695387595',
	),


);