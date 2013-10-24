<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CP&B Lab',
    'runtimePath'=>$_SERVER[ 'yii_logger_logPath' ],

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'ocpadmin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','70.197.204.20'),
		),
        
        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',

            # send activation email
            'sendActivationMail' => false,

            # allow access for non-activated users
            'loginNotActiv' => false,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => array('/user/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery'),

            # login form path
            'loginUrl' => array('/user/login'),

            # page after login
//            'returnUrl' => array('/user/profile'),
            'returnUrl' => array('/'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),        
	),

	// application components
	'components'=>array(
/*        'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array(
                    'host'=>'localhost',
                    'port'=>11211,
                ),
            ),
         ),
*/
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/usr/login'),
        ),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                // REST patterns
                // notes
                array('notesApi/list', 'pattern'=>'api/notes', 'verb'=>'GET'),
                array('notesApi/view', 'pattern'=>'api/notes/<id:\d+>', 'verb'=>'GET'),
                array('notesApi/update', 'pattern'=>'api/notes/<id:\d+>', 'verb'=>'PUT'),
                array('notesApi/delete', 'pattern'=>'api/notes/<id:\d+>', 'verb'=>'DELETE'),
                array('notesApi/create', 'pattern'=>'api/notes', 'verb'=>'POST'),
                // Basic patterns
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=eggnog.overcoffee.com;dbname=' . $_SERVER[ 'yii_database' ],
			'emulatePrepare' => true,
			'username' => '0eQ7WtLDMp',
			'password' => '0H9AWQMKG4',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
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
					'levels'=>'error, warning, trace, info',
                    'logPath'=>$_SERVER[ 'yii_logger_logPath' ],
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
		'adminEmail'=>'webmaster@overcoffee.com',
	),
);