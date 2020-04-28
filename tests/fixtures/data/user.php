<?php

return [
    'test_user' => [
        'id' => '1',
        'username' => 'test_user',
        'password' => Yii::$app->security->generatePasswordHash('test_user'),
        'authKey' => 'randomAuthKey',
        'email' => 'test_user@yandex.ru'
    ]
];