<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	'theme'=>'booking',
	'language' => 'en',
	// preloading 'log' component
	'preload'=>array('log', 'phpseclib'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'ext.yii-mail.YiiMailMessage',
		'ext.validators.ECCValidator',
	),

	'modules'=>array(
		'admin',
		'booking',
		'api',
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		)*/
	),

	// application components
	'components'=>array(
		'phpseclib' => array(
	      'class' => 'ext.phpseclib.PhpSecLib'
	    ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'class'=>'MyUrlManager'
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),
		'mailer'=>array(
            'class'=>'Mailer',
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
		'email_sent'=>'no_reply@onlinesolutions.vn',
		'link' => 'http://localhost/onlinesolutions.vn/',
		'booking'=>'http://localhost/onlinesolutions.vn/',
		'domain' => 'onlinesolutions.vn',
		'view' => require_once('confgs/view_configs.php'),
		'room_amenities' => require_once('confgs/room_amenities.php'),
		'bed_configs' => require_once('confgs/bed_configs.php'),
		'promotion_type' => require_once('confgs/promotion_type.php'),
		'cancellation_config' => require_once('confgs/cancellation_configs.php'),
		'language_configs' => require_once('confgs/language_configs.php'),
		'condition' => require_once('confgs/condition.php'),
		'mailer_config' => require_once("confgs/mailer.php"),
		'email_alert' => require('confgs/email_alert.php')
	),
);
