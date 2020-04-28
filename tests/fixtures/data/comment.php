<?php

return [
    'test_comment_0' => [
        'id' => '1',
        'number' => '1',
        'path' => '001',
        'text' => 'Text',
        'date' => date("Y-m-d H:i:s",time() + 3 * 3600),
        'fileId' => '1',
        'user' => 'test_user',
        'parentId' => '0',
    ],
    'test_comment_1' => [
        'id' => '2',
        'number' => '1',
        'path' => '001.001',
        'text' => 'Text',
        'date' => date("Y-m-d H:i:s",time() + 3 * 3600),
        'fileId' => '1',
        'user' => 'test_user',
        'parentId' => '1',
    ],
    'test_comment_2' => [
        'id' => '3',
        'number' => '2',
        'path' => '001.002',
        'text' => 'Text',
        'date' => date("Y-m-d H:i:s",time() + 3 * 3600),
        'fileId' => '1',
        'user' => 'test_user',
        'parentId' => '1',
    ]
];