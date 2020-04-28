<?php


$config = [
    'components' => [
        'db' => require __DIR__ . '/../../config/test_db.php',
        'urlManager' => [
            'showScriptName' => true
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => 'root',
            'password' => 'password'
        ],
    ]
];