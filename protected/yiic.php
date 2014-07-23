<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';
require_once __DIR__ . '/extensions/global.php';
require_once __DIR__ . '/extensions/functions.php';

require_once($yiic);

spl_autoload_unregister(array('YiiBase', 'autoload'));
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register(array('YiiBase', 'autoload'), true, true);

