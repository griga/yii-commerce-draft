<?php
return [
	'components'=>[
		 'db'=>  getenv('OPENSHIFT_MYSQL_DB_HOST') ? [
            'connectionString' => 'mysql:host=' . getenv('OPENSHIFT_MYSQL_DB_HOST') . ';dbname=',
            'emulatePrepare' => true,
            'tablePrefix'=>'cmr_',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ] : [
            'connectionString' => 'mysql:host=localhost;dbname=',
            'emulatePrepare' => true,
            'tablePrefix'=>'cmr_',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
	],
	 'params' => [
        'systemEmail' => 'grigach@gmail.com',
        'systemName' => 'Тестирование сервиса',
        'langFull' => [
            'uk' => 'Українська',
            'ru' => 'Русский',
            'en' => 'English',
        ],
        'langSmall' => [
            'uk' => 'Укр',
            'ru' => 'Рус',
            'en' => 'Eng',
        ],
        'defaultLanguage' => 'ru',
        'emails_in_minute' => 1,
        'email_sleep' => 10,
        'adminEmail' => 'gmail@gmail.com',
        'dataDir' => getenv('OPENSHIFT_DATA_DIR') ? getenv('OPENSHIFT_DATA_DIR') : realpath(__DIR__ . '/../../'),
        'mail' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => '_@gmail.com',
            'password' => '',
        ]
    ],
];