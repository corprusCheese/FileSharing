<?php

return [
    'test_file' => [
        'id' => '1',
        'name' => 'dummy',
        'size' => '0',
        'downloadDate' => date("Y-m-d H:i:s",time() + 3 * 3600),
        'extension' => 'txt',
        'userAuthKey' => 'randomAuthKey',
    ],
    'cat_jpg' => [
        'id' => '2',
        'name' => 'test_cat',
        'size' => '1024',
        'downloadDate' => date("Y-m-d H:i:s",time() + 3 * 3600),
        'extension' => 'jpg',
        'userAuthKey' => 'randomAuthKey',
    ]
];