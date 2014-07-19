<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
	
    array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		 'theme'=>'theme', // requires you to copy the theme under your themes directory
			'modules'=>array(
				'gii'=>array(
					'generatorPaths'=>array(
						'bootstrap.gii',
					),
				),
			),
			
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
			   
        // Put front-end settings there
    	'defaultController'=>'index/index',
		'aliases' => array(
        // yiistrap configuration
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change if necessary
        // yiiwheels configuration
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
    ),
		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
         'bootstrap.helpers.TbArray',
         'bootstrap.helpers.TbHtml',
         'bootstrap.behaviors.TbWidget',
		),
		'modules'=>array(
		// uncomment the following to enable the Gii tool
	
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			'ipFilters'=>array($_SERVER['REMOTE_ADDR']),
		),
		
	),
		'components'=>array(
		'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
                    'loginUrl'=>array('/index'),
                  'authTimeout'=>1000,  // 5 minutes.              

			//'class' => "UserIdentity",
        ),
		   'bootstrap'=>array(
				//'class'=>'bootstrap.components.Bootstrap',
            'class' => 'bootstrap.components.TbApi',
			),
         'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',   
        ),
			 'import' => 'application.components.EButtonColumnWithClearFilters',
			
			'errorHandler'=>array(
				// use 'index/error' action to display errors
				'errorAction'=>'index/error',
			),
		'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,
		'rules'=>array(
//(^[dp][0-9]*$)
        'pic/<userId:([0-9]+)>/<userName>'=>'commonfront/userpic',
        'video/<userId:([0-9]+)>/<userName>'=>'commonfront/uservideo',
        'smallpic/<userId:([0-9]+)>/<userName>'=>'commonfront/smallpic',
        'smallpic/<dimension:(([0-9]{2,3})x([0-9]{2,3}))>/<userId:([0-9]+)>/<userName>'=>'commonfront/smallpic',
        'catg/<catgId:\d+>/<catgDesc>'=>'commonfront/catPic',
        'catg/<dimension:(([0-9]{2,3})x([0-9]{2,3}))>/<catgId:([0-9]+)>/<catgDesc>'=>'commonfront/catPic',
         'confirmation/<taskId:([0-9]+)>/<userName>'=>'poster/confirmtask',
         'task/<taskId:([0-9]+)>/<taskDesc>'=>'commonfront/taskPic',
         'task/<dimension:(([0-9]{2,3})x([0-9]{2,3}))>/<taskId:([0-9]+)>/<userName>'=>'commonfront/taskPic',
         'profile/t/<userId:([0-9]+)>/<userName>' => 'userprofile/viewtaskerprofile',
         'profile/p/<userId:([0-9]+)>/<userName>' => 'poster/viewprofile',
         'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>' => 'poster/taskdetail',
         'public/tasks/<taskType>/<categoryName>/<taskTitle>/<taskId:\d+>' => 'poster/taskdetail',
         'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>/<filename>' => 'commonfront/taskattachment',
        'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>/<filename>/s' => 'commonfront/taskattachmentthumb',
        'public/tasks/<taskType>/<categoryName>/<taskTitle>/<taskId:\d+>/<filename>' => 'commonfront/taskattachment',
        'public/tasks/<taskType>/<categoryName>/<taskTitle>/<taskId:\d+>/<filename>/s' => 'commonfront/taskattachmentthumb',
        'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>/<porposalId:\d+>/<filename>' => 'commonfront/proposalattachment',
        'public/tasks/<taskType>/<categoryName>/<taskTitle>/<taskId:\d+>/<porposalId:\d+>/<filename>/proposal' => 'commonfront/proposalattachment',
        'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>/<porposalId:\d+>/<filename>/proposal' => 'commonfront/proposalattachment',
        'public/tasks/<taskType>/<categoryName>/<subCategoryName>/<taskTitle>/<taskId:\d+>/<porposalId:\d+>/<filename>/proposal/s' => 'commonfront/proposalattachmentthumb',
        'public/tasks/<taskType>/<categoryName>/<taskTitle>/<taskId:\d+>/<porposalId:\d+>/<filename>/proposal/s' => 'commonfront/proposalattachmentthumb',
         
        //'public/tasks/<taskType>/<s:([A-Za-z0-9-\/]+)>' => 'tasker/tasklist',
        
        'public/tasks' => 'tasker/tasklist',
        'public/tasks/<taskType>' => 'tasker/tasklist',
        'public/tasks/<taskType>/<categoryName>' => 'tasker/tasklist',
        'public/tasks/<taskType>/<categoryName>/<subCategoryName>' => 'tasker/tasklist',
        'poster/mytasks/<taskType>' => 'poster/mytasks',
        'poster/mytasks/<taskType>/<categoryName>' => 'poster/mytasks',
        'poster/mytasks/<taskType>/<categoryName>/<subCategoryName>' => 'poster/mytasks',
        array(
           'class' => 'application.components.SearchUrlRule',
        ),
        
        'tasker/mytasks/<taskType>' => 'tasker/mytasks',
        'tasker/mytasks/<taskType>/<categoryName>' => 'tasker/mytasks',
        'tasker/mytasks/<taskType>/<categoryName>/<subCategoryName>' => 'tasker/mytasks',
        'public/media/image/<filename>' => 'commonfront/publicimage',
      	'<_c>'=>'<_c>',
        '<_c>/<_a>'=>'<_c>/<_a>',
				),
			),
         'request'=>array(
//           'enableCsrfValidation'=>true,
//        
             'class'=>'application.components.HttpRequest',
                'enableCsrfValidation'=>true,
                 'csrfTokenName'=>'YII_CSRF_TOKEN',
                'enableCookieValidation'=>true,

                'noCsrfValidationRoutes'=>array(
                    'poster/uploadtaskfiles' ,
                    'index/updateimage',
                    'index/updatevideouser' ,
                    'user/uploadportfolioimage' ,
                    'user/uploadportfoliovideo',
                    'commonfront/sendmailtest','commonfront/sendmailtestcurl','commonfront/sendmail'),

         ), //end of request
		),
      

    )
);