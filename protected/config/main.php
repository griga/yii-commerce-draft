<?php
//Yii::setPathOfAlias('Phly', dirname(__FILE__) . '/../vendor/Phly');
//Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../vendor');


return CMap::mergeArray([
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',

    'preload' => ['log'],

    'import' => [
        'zii.behaviors.CTimestampBehavior',
        'application.models.*',
        'application.components.*',
        'application.components.behaviors.*',
        'ext.yiiext.components.shoppingCart.*',
        'application.modules.catalog.models.*',
        'application.modules.shopping.models.*',
        'application.modules.content.models.*',
        'application.modules.upload.models.*',
        'application.modules.upload.components.*',
        'application.modules.user.models.*',
        'application.modules.sys.components.*',
        'application.modules.sys.models.*',
        'application.modules.seo.components.*',
        'application.modules.seo.models.*',
    ],

    'modules' => [
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => ['127.0.0.1', '::1'],
        ],
        'store',
        'upload',
    ],

    'components' => [
        'phpThumb' => [
            'class' => 'application.modules.upload.components.YgPhpThumb',
        ],
        'user' => [
            'class' => 'WebUser',
            'loginUrl' => ['site/login'],
            'allowAutoLogin' => true,
        ],
        'cache' => [
            'class' => 'CFileCache',
        ],
        'mustache'=>[
            'class'=>'MustacheService',
        ],
        'mailer' => [
            'class' => 'EMailer',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
                /*    [
                        'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
  //                      'ipFilters'=>['127.0.0.1'],
                    ],
            /*  *  // uncomment the following to show log messages oneb pages
                   /*
                   [
                       'class'=>'CWebLogRoute',
                   ],
                   */
            ],
        ],
        'clientScript' => [
            'class' => 'ext.yg.client-script.YgClientScript',
            'packages' => [
                'jquery' => [
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/',
                    'js' => ['jquery.min.js'],
                ],
                'jquery.ui' => [
                    'baseUrl' => '',
                    'js' => ['//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'],
                    'depends' => ['jquery'],
                ],
                'angular' => [
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/',
                    'js' => ['angular.min.js'],
                    'depends' => ['jquery'],
                ],
                'angular.route' => [
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/',
                    'js' => ['angular-route.min.js'],
                    'depends' => ['angular'],
                ],
                'angular.resource' => [
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/',
                    'js' => ['angular-resource.min.js'],
                    'depends' => ['angular'],
                ],
                'angular.animate' => [
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/',
                    'js' => ['angular-animate.min.js'],
                    'depends' => ['angular'],
                ],
                'bootstrap' => [
                    'baseUrl' => '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/',
                    'js' => ['bootstrap.min.js'],
                ],
                'knockout' => [
                    'baseUrl' => '//cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/',
                    'js' => ['knockout-min.js'],
                ],
            ],
            'scriptMap' => [
                'jquery-ui.min.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
                'jquery-ui.css' => '/themes/commerce/back/css/jquery-ui-1.10.3.custom.css',
            ],
        ],
    ],
    'behaviors' => [
        'runEnd' => [
            'class' => 'application.components.behaviors.WebApplicationEndBehavior',
        ],
        'clearScripts' => [
            'class' => 'ext.yg.client-script.CleanupBehavior'
        ],
    ],
    'sourceLanguage' => 'en',
    'language' => 'en',
   
], require_once __DIR__ .'/project.php');