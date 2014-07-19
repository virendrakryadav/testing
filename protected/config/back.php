<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Green Comet',
                'sourceLanguage' => 'en_de',
		'language' => 'en_us',
                'behaviors'=>array(
                'onBeginRequest' => array(
                    'class' => 'application.components.behaviors.BeginRequest'
                        ),
                ),
                        'params' => array(
                        'languages'=>array('en_us'=>'English US', 'fr'=>'French','en_gb'=>'English UK', 'es'=>'Spanish'),
                 ), 

        // Put back-end settings there.
		'defaultController'=>'index/login',
		
		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
		),
		'modules'=>array(	
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
                    'ipFilters'=>array($_SERVER['REMOTE_ADDR']),
			),
		),
		'components'=>array(
		/*'request'=>array(
            'enableCookieValidation'=>true,
        ),*/
		'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
			'allowAutoLogin'=>true,
            'autoRenewCookie' => true,
			'loginUrl'=>array('/index/login'),
			//'class' => "UserIdentity",
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'index/error',
		),
		'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,
		'rules'=>array(
			'admin'=>'index/login',
			'admin/<_c>'=>'<_c>',
			'admin/<_c>/<_a>'=>'<_c>/<_a>',
				),
			),
		),
    )
	
);