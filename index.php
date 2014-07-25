<?php

$rootDir = __DIR__;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

//if(getenv('OPENSHIFT_APP_NAME')){
//     production mode
//    defined('YII_DEBUG') or define('YII_DEBUG', false);
//    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
//    $yii = $rootDir . '/protected/extensions/yii/yiilite.php';
//} else {
// developer mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
//    $yii = $rootDir . '/protected/extensions/yii/yii.php';
$yii = $rootDir . '/protected/vendor/yiisoft/yii/framework/yii.php';
//}

$config = $rootDir . '/protected/config/front.php';

require_once $yii;

require_once $rootDir . '/protected/extensions/global.php';
require_once $rootDir . '/protected/extensions/functions.php';

spl_autoload_unregister(array('YiiBase', 'autoload'));
$loader = require rootDir . '/protected/vendor/autoload.php';
spl_autoload_register(array('YiiBase', 'autoload'), true, true);

foreach ($loader->getClassMap() as $class => $patch)
    Yii::$classMap[$class] = $patch;

Yii::createWebApplication($config)->runEnd('front');

