<?php

namespace app\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class CommentController extends MyApiController{
    public $modelClass = 'app\models\Comment';
}