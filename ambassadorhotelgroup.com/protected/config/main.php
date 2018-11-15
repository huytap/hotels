<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Hotel in Ho Chi Minh',
	'theme' => 'carinosaigonhotel',
	'language' => 'en',
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'ext.yii-mail.YiiMailMessage',
		'ext.validators.ECCValidator',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin', 
		'carinosaigonhotel',
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'clientScript' => array(
            'scriptMap' => array(
                //'jquery.js' => 'http://carinosaigonhotel.com/themes/carinosaigonhotel/javascripts/jquery-1.10.2.js',
                'jquery.js' => false
            ),
        ),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			//'rules' => require_once('confgs/router.php'),
			'class'=>'MyUrlManager'
		),
		'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
		'settings'=>array(
	        'class'                 => 'CmsSettings',
	        'cacheComponentId'  => 'cache',
	        'cacheId'           => 'global_website_settings',
	        'cacheTime'         => 84000,
	        'tableName'     => 'settings',
	        'dbComponentId'     => 'db',
	        'createTable'       => true,
	        'dbEngine'      => 'InnoDB',
        ),
		'db'=>require_once('confgs/dbconfgs.php'),
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
	'params'=>array(
		//'ldap_config' => require_once("confgs/ldap.php"),
		'adminEmail'=>'webmaster@example.com',
		'link' => 'http://localhost/ambassadorhotelgroup.com/',
		'booking'=>'http://localhost/ambassadorhotelgroup.com/',
		'view' => require_once('confgs/view_configs.php'),
		'room_amenities' => require_once('confgs/room_amenities.php'),
		'bed_configs' => require_once('confgs/bed_configs.php'),
		'promotion_type' => require_once('confgs/promotion_type.php'),
		'cancellation_config' => require_once('confgs/cancellation_configs.php'),
		'language_configs' => require_once('confgs/language_configs.php'),
		'menu' => require_once('confgs/menu.php'),
		'cms_type'=>require_once('confgs/cms_type.php'),
		'tour_config' => require_once('confgs/tour_config.php'),
		'condition' => require_once('confgs/condition.php'),
		'type_des' => require_once('confgs/type_des.php'),
		'mailer_config' => require_once("confgs/mailer.php"),
		'gallery_category' => require_once("confgs/gallery_category.php"),
	),
);