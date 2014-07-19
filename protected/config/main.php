<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	// preloading 'log' component
	'preload'=>array('log'),
	'import'=>array(
			'application.models.*',
			'application.components.*',
			'ext.YiiMailer.YiiMailer',
         'application.extensions.scriptboost.*',
//                        'application.vendors.phpexcel.PHPExcel',
 'application.extensions.BraintreeApi.*',
             'ext.easyimage.EasyImage',
            
	),
	/*'modules' => array(
    // name and version of the module
    'apiv1' => array(
        'class' => 'application.modules.apiv1.Apiv1Module',
        // optional configuration:        
        //'baseUrl' => 'api.myproject.com', // skip to use path format myproject.com/api1
        'lastUpdateAttribute' => 'update_time', // DATETIME field that contains last update time of active record
        'format' => 'json', // only json is supported so far 
        //'authModelClass' => 'FrAuthModel', // override this class to change authentication behavior
        //'myAuthenticatedModelClass' => 'Organization', // active record that used for login
       // 'myAuthenticatedModelPasswordField' => 'api_password',
    ),
),*/

	// application components
	'components'=>array(
   'securityManager'=>array(
            'cryptAlgorithm' => 'rijndael-256', //blowfish //it is 5-7 times faster than rijndael-256 
            'encryptionKey' => '$er45b$du$n',
        ),
            'easyImage' => array(
    'class' => 'application.extensions.easyimage.EasyImage',
                //'driver' => 'GD',
    //'quality' => 100,
    //'cachePath' => '/assets/easyimage/',
    //'cacheTime' => 2592000,
    //'retinaSupport' => false,
  ),
            
		/*'import'=>array(
                'application.extensions.imageAttachment',
         ),*/
		/*// uncomment the following to use a MySQL database
		'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
			'loginUrl'=>'index/login',
			//'class' => "UserIdentity",
        ),*/
		
		/* 'user'=>array(
                'class' => 'UserIdentity',
                'allowAutoLogin'=>true,
                'autoRenewCookie' => true,
                'identityCookie' => array('domain' => 'http://192.168.1.200:8080'),
                'loginUrl'=>'http://192.168.1.200:8080/greencometdev/admin/index/login',
                ),
           'session' => array(
                    'class' => 'CDbHttpSession',
                    'cookieParams' => array('domain' => 'http://192.168.1.200:8080'),
                    'timeout' => 3600,
                	'connectionID' => 'db',
                    'sessionName' => 'session',
                 ),
		'image'=>array(
            'class'=>'application.extensions.imageAttachment.ImageAttachmentBehavior',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
        ),*/
            'user'=>array(

                        'allowAutoLogin'=>true,
                        'authTimeout'=>1000,  // 5 minutes.              
                ),
            'session' => array(
                'timeout' => 7200,
                ),
// 'request' => array(
//                'class' => 'application.components.EHttpRequest',
//        ),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=greencomet_dev',
            'enableParamLogging'=>true,
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'gc_',
		),
		'cache' => array (
           'class' => 'system.caching.CFileCache',
       ),
            
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(

				array(
					'class'=>'CFileLogRoute',    //CWebLogRoute/CFileLogRoute           
					'levels'=>CLogger::LEVEL_TRACE,
					'logFile' => 'debug.log',
					'maxFileSize' => 1,
    				'maxLogFiles' => 10,
        		),
				array(
					'class'=>'CFileLogRoute',    //CWebLogRoute/CFileLogRoute           
					'levels'=>CLogger::LEVEL_INFO,
					'logFile' => 'info.log',
					'maxFileSize' => 1,
    				'maxLogFiles' => 10,
        		),
				array(
					'class'=>'CFileLogRoute',    //CWebLogRoute/CFileLogRoute           
					'levels'=>CLogger::LEVEL_WARNING,
					'logFile' => 'warning.log',
					'maxFileSize' => 1,
    				'maxLogFiles' => 10,
        		),
					array(
					'class'=>'CFileLogRoute',    //CWebLogRoute/CFileLogRoute           
					'levels'=>CLogger::LEVEL_ERROR,
					'logFile' => 'error.log',
					'maxFileSize' => 1,
    				'maxLogFiles' => 10
        		),
				array(
					'class'=>'ProfileLogRoute',    //CWebLogRoute/CFileLogRoute      
					//'class'=>'application.components.CProfileToFileLogRoute',  
					'levels'=>CLogger::LEVEL_PROFILE,
					//'categories' => 'profiler',
					'logFile' => 'profile.log',
					
        		),
//                     array(
//                'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
//                'ipFilters'=>array('127.0.0.1','192.168.1.*', '192.168.1.200:8080'),
//            ),	
			),
		),
      //'clientScript' => array(
//         'class'=>'EClientScriptBoost',
//         'cacheDuration'=>30,
//         ),
//      'assetManager' => array(
//         'class' => 'EAssetManagerBoost',
//         'minifiedExtensionFlags'=>array('min.js','minified.js','packed.js')
//        ),
	),
	
	'behaviors'=>array(
    'runEnd'=>array(
        'class'=>'application.components.WebApplicationEndBehavior',
    ),
    /*'urlManager' => array(
        'rules' => array(
            // custom actions in resource controller
            array('apiv1/<controller>/<action>', 'pattern' => 'apiv1/<controller:\w+>/<action:\w+>/<id:\d+>'),
            // crud for resource controller
            array('apiv1/<controller>/<action>', 'pattern' => 'apiv1/<controller:\w+>/<action:\w+>'),
            // everything else goes to the default controller
            array('apiv1/default/<action>', 'pattern' => 'apiv1/<action:\w+>'),
        ),
    ),  */ 
),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
date_default_timezone_set('Asia/Calcutta');