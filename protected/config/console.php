<?php

Yii::setPathOfAlias('upload', __DIR__.'/../modules/upload');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray([
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>['log'],
    'import'=>[
        'application.models.*',
        'application.components.*',
        'application.components.behaviors.*',
        'ext.yiiext.components.shoppingCart.*',
        'application.modules.catalog.models.*',
        'application.modules.upload.models.Upload',
        'application.modules.upload.components.*',
    ],
    'commandMap'=>[
        'populate'=>[
            'class'=>'application.commands.shell.PopulateCommand'
        ],
    ],

	// application components
	'components'=>[
       
		'log'=>[
			'class'=>'CLogRouter',
			'routes'=>[
				[
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				],
			],
		],
	],
], require_once __DIR__ .'/project.php');