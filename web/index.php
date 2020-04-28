<?php

//дебаг режим
define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//автозагрузка
require '../vendor/autoload.php';
require '../vendor/yiisoft/yii2/Yii.php';
//суешь конфиг
$config = require '../config/web.php';
//

//запуск
$app = new yii\web\Application($config);
$app->run();

//\app\controllers\SiteController::