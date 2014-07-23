<?php

Yii::setPathOfAlias('widgets', __DIR__ . '/../../themes/cine/widgets');

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    [
        'name' => 'All Projectors',

        'theme' => 'projectors',

        'homeUrl' => ['/site/index'],

        'import' => [
            'application.controllers.front.*',
        ],

        'modules' => [
            'user',
            'shopping',
        ],
        'components' => [
            'seo'=>[
                'class'=>'SeoDispatcher'
            ],
            'user' => [
                'stateKeyPrefix' => 'front',
                'allowAutoLogin' => true,
//                'class' => 'WebUser',
                'loginUrl' => '/user/auth/login'
            ],
            'shoppingCart' =>
                [
                    'class' => 'application.modules.shopping.components.CommerceCart',
                ],

            'urlManager' => [
                'class' => 'LanguageUrlManager',
                'urlFormat' => 'path',
                'showScriptName' => false,
                'useStrictParsing' => true,
                'exclude' => ['gii', 'images', 'oauth2callback'],
                'rules' => [
//                    'api/manufacturer'=>'api/manufacturer',
//                    'user' => 'user',
//                    'user/<controller:\w+>'=>'user/<controller>',
//                    'user/<controller:\w+>/<action:\w+>'=>'user/<controller>/<action>',
//
//                    '<lang:(\w{2})>/contacts' => 'site/contacts',
//
//                    '<lang:(\w{2})>' => 'site/index',
//                    '' => 'site/index',
//                    'captcha' => 'site/captcha',
//                    '<lang:(\w{2})>/<url>' => 'menu/index',
//
//                    'translation' => 'translation',
//                    'translation/<controller:\w+>/<action:\w+>'=>'translation/<controller>/<action>',

                    'images/<model:\w+>/<filename:[\w\d\.\/]+>' => 'images/index',

                    '' => 'site/index',
                    '<lang:(\w{2})>' => 'site/index',
                    '<lang:(\w{2})>/brand/<alias:[\w\d-\/]+>' => 'site/brand',
                    '<lang:(\w{2})>/product/<alias:[\w\d-\/]+>' => 'site/product',
                    '<lang:(\w{2})>/page/<alias:[\w\d-\/]+>' => 'site/page',
                    '<lang:(\w{2})>/basket' => 'site/index',
                    '<lang:(\w{2})>/order' => 'site/index',
                    '<lang:(\w{2})>/success' => 'site/index',

                    '<lang:(\w{2})>/site/oauth' => 'user/auth/oauth',
                    'oauth2callback' => 'user/auth/oauth',
                    '<lang:(\w{2})>/sign-in' => 'user/auth/login',
                    '<lang:(\w{2})>/sign-out' => 'user/auth/logout',
                    '<lang:(\w{2})>/static/<alias:[\w-\/]+>' => 'content/page',
                    '<lang:(\w{2})>/<alias:[\w\d-\/]+>/c<id:\d+>' => 'catalog/category',
                    '<lang:(\w{2})>/<alias:[\w\d-\/]+>/p<id:\d+>' => 'catalog/product',
                    '<lang:(\w{2})>/<module>' => '<module>',
                    '<lang:(\w{2})>/<module>/<controller:[\w-]+>/<id:\d+>' => '<module>/<controller>/view',
                    '<lang:(\w{2})>/<module>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                    '<lang:(\w{2})>/<module>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
                    '<lang:(\w{2})>/<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                    '<lang:(\w{2})>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                    '<lang:(\w{2})>/<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                    '<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                    '<module>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

                ],
            ],
        ],
    ]
);
