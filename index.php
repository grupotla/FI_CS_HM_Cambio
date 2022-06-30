<?php

//	header("Location: http://10.10.1.61/catalogo_admin/cambio/index.php?r=site/login");

//	die();

// change the following paths if necessary
$yii=dirname(__FILE__).'/../Yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
