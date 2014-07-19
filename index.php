<?php
//error_reporting(E_ALL & ~E_STRICT);
$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/front.php';
 
// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_PROFILE') or define('YII_PROFILE', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);
defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', true);
 
require_once($yii);
Yii::createWebApplication($config)->runEnd('front');
