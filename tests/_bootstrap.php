<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../vendor/autoload.php';

//vendor\se\selenium-server-standalone\bin
//java -jar -Dwebdriver.gecko.driver=/path/to/geckodriver /path/to/selenium-server-standalone-3.0.1.jar