<?php

// -----

define('YII_DEBUG',$_SERVER['REMOTE_ADDR']=='127.0.0.1');
define('IS_BACKEND',false);
define('IS_FRONTED',true);

if(YII_DEBUG) {
    define('YII_TRACE_LEVEL',3);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
} else {
    error_reporting(0);
}

$yii=dirname(__FILE__).'/yii/yii.php';

if(!file_exists($yii))
    $yii=dirname(__FILE__).'/../yii/yii.php';

require_once($yii);

$webroot=dirname(__FILE__).DIRECTORY_SEPARATOR;
Yii::setPathOfAlias('common', $webroot.'common');
Yii::setPathOfAlias('frontend', $webroot.'frontend');
Yii::setPathOfAlias('backend', $webroot.'backend');

$config=include(Yii::getPathOfAlias('common.config.main').'.php');
$config=CMap::mergeArray($config, include(Yii::getPathOfAlias('frontend.config.main').'.php'));
if($_SERVER['REMOTE_ADDR']=='127.0.0.1')
    $config=CMap::mergeArray($config, include(Yii::getPathOfAlias('common.config.main-local').'.php'));

Yii::createWebApplication($config)->run();