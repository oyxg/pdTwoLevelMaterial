<?php
//包含框架与配置文件
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
//开启调试模式
defined('YII_DEBUG') or define('YII_DEBUG',true);
//指示日志调用栈等级
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//运行框架
require_once($yii);
ini_set("display_errors","Off");
error_reporting(0);
$app=Yii::createWebApplication($config);
$app->run();
