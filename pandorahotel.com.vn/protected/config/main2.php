<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Administrator',
	'theme' => 'admin',
	// preloading 'log' component
	'preload'=>array('log','booster'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'ext.gapi-google-analytics.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin', 
		'm',
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
		
	),

	// application components
	'components'=>array(
		'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => 'https://code.jquery.com/jquery-1.10.2.min.js'
                //'jquery.js' => 'http://localhost/hotels/themes/admin/js/jquery-1.10.2.min.js'
            ),
        ),
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'WebUser',
			'allowAutoLogin'=>true,
		),
		'booster' => array(
            'class' => 'ext.yiibooster.components.Booster',
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'admin' => 'admin/site/login',
				'admin/<controller>/<action>' => 'admin/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'setting'=>array(
	        'class'                 => 'CmsSettings',
	        'cacheComponentId'  => 'cache',
	        'cacheId'           => 'global_website_settings',
	        'cacheTime'         => 84000,
	        'tableName'     => 'system_settings',
	        'dbComponentId'     => 'db',
	        'createTable'       => true,
	        'dbEngine'      => 'InnoDB',
        ),
		'db'=>require_once('confgs/dbconfgs.php'),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			//'errorAction'=>'admin/site/error',
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
		'adminEmail'=>'webmaster@example.com',
		'all_roles' => require_once('confgs/roles.php'),
		'view' => require_once('confgs/view_configs.php'),
		'room_amenities' => require_once('confgs/room_amenities.php'),
		'bed_configs' => require_once('confgs/bed_configs.php'),
		'promotion_type' => require_once('confgs/promotion_type.php'),
		'cancellation_configs' => require_once('confgs/cancellation_configs.php'),
		'facilities' => require_once('confgs/facilities_configs.php'),
		'sports' => require_once('confgs/sport_configs.php'),
		'language_config' => require_once('confgs/language_configs.php'),
		'uploadPath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'../uploads/',
		'apply_on_config'=>require_once('confgs/apply_on_config.php'),
		'cms_type'=>require_once('confgs/cms_type.php'),
		'slide_type'=>require_once('confgs/slide_type.php'),
		'type_des' => require_once('confgs/type_des.php'),
		'special' => require_once('confgs/special_offer.php'),
		'gallery_category' => require_once("confgs/gallery_category.php"),
	),
);