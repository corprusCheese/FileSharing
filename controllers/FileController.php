<?php


namespace app\controllers;

use app\models\Comment;
use app\models\SearchForm;
use app\other\SphinxHelper;
use Yii;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\File;
use app\models\CommentForm;


class FileController extends Controller
{
    //страница файла
    public function actionView(){
        //находит файл в базе
        $fileId = Yii::$app->request->get('id');
        /* @var $model File */
        $model = File::find()->where(['id'=>$fileId])->one();

        if ($model==null){
            return $this->redirect("error");
        }
        //находит файл
        $fileName = $model->name.'.'.$model->extension;
        $filePath = File::getFolder($model,false) .'\\' .$fileName;

        //сохранить коммент
        $commentModel = new CommentForm();
        if ($commentModel->load(Yii::$app->request->post())&&$commentModel->saveComment($fileId)){
            return $this->redirect(array("file/view",'id' =>$fileId));
        }

        //SphinxHelper::deleteAllRt();
        return $this->render('view',[
            'model' => $model,
            'filePath' => $filePath,
            'commentModel' => $commentModel
        ]);
    }

    //удаление данных из таблиц comment и file
    public function actionDelete(){
        //находит файл в базе
        $fileId = Yii::$app->request->get('id');
        //находит fileid в списке файлов пользователя
        //нужна какая-то защита от экшена
        try {
            $myAuthKey = Yii::$app->user->getIdentity()->getAuthKey();
        }
        catch (Exception $e){
            $myAuthKey = 'I am guest';
        }
        $myFiles = File::find()->where([
            'userAuthKey' => $myAuthKey,
            'id' => $fileId
        ])->all();
        if($myFiles==null){
            return $this->redirect(Url::to(['/site/error']));
        }

        //получает всех детей и удаляет их
        $comments = Comment::find()->where(['fileId'=>$fileId])->all();
        foreach ($comments as $i)
            $i->delete();

        $model = File::find()->where(['id'=>$fileId])->one();
        $fileName = $model->name.'.'.$model->extension;
        $filePath = File::getFolder($model,true) .'\\' .$fileName;

        //удаляет из базы файл
        $model->delete();

        //удаляет из папки
        try {
            unlink($filePath);
        }
        catch(\Exception $e){}

        SphinxHelper::deleteFromRt($fileId);

        //редирект
        return $this->redirect(Url::to(['site/lastloads']));
    }

    //загрузка пользователю
    public function actionDownload(){

        //находит файл в базе
        $fileId = Yii::$app->request->get('id');
        $model = File::find()->where(['id'=>$fileId])->one();

        //получает путь к файлу
        $fileName = $model->name.'.'.$model->extension;
        $absFilePath = File::getFolder($model,true) .'\\' .$fileName;
        //$filePath = File::getFolder($model) .'\\' .$fileName;

        if (file_exists($absFilePath)) {
            Yii::$app->response->SendFile($absFilePath)->send();
        }
        else {
            throw new \Exception('Файл '.$fileName.' не найден');
        }
    }

    //отключение валидации при Ajax
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}