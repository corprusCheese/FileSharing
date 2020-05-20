<?php

namespace app\modules\api\v1;

use Yii;

class ApiModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    public function init()
    {
        parent::init();
    }
}