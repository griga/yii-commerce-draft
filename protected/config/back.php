<?php

Yii::setPathOfAlias('yg', __DIR__.'/../extensions/yg');

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    [
        'name' => 'Commerce Admin',

        'theme' => 'commerce/back',

        'defaultController' => 'dashboard',
        'homeUrl' => ['/dashboard/index'],
        'import' => [
            'application.controllers.back.*',

            'application.modules.upload.components.*',
            'application.modules.upload.models.*',
            'application.modules.seo.models.*',
        ],

        'modules' => [
            'catalog',
            'translation' => [
                'layout' => '//layouts/main',
                'baseUrl' => '/admin/translation/module',
                'languages' => [
                    'en' => 'English',
                    'ru' => 'Русский',
                    'uk' => 'Українська',

                ],
                'sourceLanguage' => 'en',
            ],
            'content',
            'user',
            'sys',
            'seo',
        ],
        'components' => [
            'urlManager' => [
                'class'=>'BackEndUrlManager',
                'urlFormat'=>'path',
                'showScriptName' => false,
                'rules' => [
                    'admin' => '/dashboard/index',

                    ['api/view', 'pattern' => 'admin/api/<model:[\w-]+>/<id\d+>', 'verb' => 'GET'],
                    ['api/list', 'pattern' => 'admin/api/<model:[\w-]+>/', 'verb' => 'GET'],
                    ['api/create', 'pattern' => 'admin/api/<model:[\w-]+>', 'verb' => 'POST'],
                    ['api/update', 'pattern' => 'admin/api/<model:[\w-]+>/<id\d+>', 'verb' => 'POST'],
                    ['api/delete', 'pattern' => 'admin/api/<model:[\w-]+>/<id\d+>', 'verb' => 'DELETE'],

                    'admin/<module>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/view',
                    'admin/<module>/<controller:[\w-]+>/<action:[\w-]+>/<id>' => '<module>/<controller>/<action>',
                    'admin/<module>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',


                    'admin/<controller:[\w-]+>' => '<controller>',
                    'admin/<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                    'admin/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                    'admin/<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                ],
            ],
            'user' => [
                'stateKeyPrefix' => 'back',
                'allowAutoLogin' => true,
                'class' => 'WebUser',
                'loginUrl' => '/admin/site/login',
            ],
        ],
    ]
);