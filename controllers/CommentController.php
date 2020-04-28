<?php


namespace app\controllers;

use app\models\Comment;
use app\models\SearchForm;
use app\models\User;
use app\other\SphinxHelper;
use Yii;
use yii\base\ErrorException;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\File;
use app\models\CommentForm;


class CommentController extends Controller{

    public function actionDelete(){
        $commentId = Yii::$app->request->get('id');

        //если кто-нибудь введет экшн на удаление
        //то сделать это будет нельзя
        try {
            $myAuth = Yii::$app->user->getIdentity()->getAuthKey();
        }
        catch (\Exception $e){
            return $this->redirect(Url::to(['/site/error']));
        }

        $myUsername = User::findUserByAuth($myAuth)->username;
        $myComment = Comment::find()->where([
            'user' => $myUsername,
            'id' => $commentId
        ])->one();

        if (!is_object($myComment))
            return $this->redirect(Url::to(['/site/error']));

        $model = Comment::find()->where(['id'=>$commentId])->one();
        try {
            $fileId = $model->fileId;
        }
        catch (ErrorException $e){
            return $this->redirect(Url::to(['/site/error']));
        }

        $model->deleteComment();
        return $this->redirect(array("file/view",'id' =>$fileId));
    }

}