<?php

namespace app\controllers;

use app\models\FileSearch;
use app\models\SearchForm;
use app\other\DbHelper;
use Exception;
use Yii;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\FileForm;
use yii\debug\panels\EventPanel;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

class SiteController extends \yii\web\Controller{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => 'error'
            ],
        ];
    }

    //главная
    public function actionIndex(){
        $model = new FileForm();

        /*
        if (Yii::$app->user->can('allFiles')){
            return $this->redirect(['../admin/site/index']);
        }*/

        return $this->render('index',[
            'model' => $model
    ]);
    }

    //логин
    public function actionLogin(){
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())&&$model->login()){
            if (Yii::$app->user->can('allFiles'))
                $this->redirect(['admin/site/index']);
            else{
                $this->redirect(['site/index']);
            }
        }

        return $this->render('login',[
             'model' => $model
        ]);
    }

    //регистрация
    public function actionRegister(){
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())){
            if ($model->save()){
                $this->redirect(['site/index']);
            }
            else{
                Yii::$app->session->setFlash('error',
                    'Пользователь с таким именем или email уже есть в базе');
            }
        }

        return $this->render('register',[
            'model' => $model
        ]);
    }

    //разлогинивание
    public function actionLogout(){
        Yii::$app->user->logout();
        $this->redirect(['site/index']);
        return $this->render('index');
    }

    //страница загрузок пользователя
    public function actionLastloads(){

        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('lastloads',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
            ]);
    }

    //экшн на загрузку файлов на сервер
    public function actionUploads(){

        $model = new FileForm();
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');
            $model->upload();
        }
        return true;
    }

    //экшн на сфинкс
    public function actionSearch(){

        $model = new SearchForm();
        $model->load(Yii::$app->request->post());
        $files = $model->search();

        // так как я не делал дельту
        // то удаление из  main_idx не будет
        // хотя эти записи не выведутся
        // их количество останется
        // поэтому нужно пересчитать
        $realFileCount = 0;
        if ($files)
            foreach ($files as $file){
                $file = \app\models\File::getFileById($file['id']);
                if ($file == null)
                    continue;
                else
                    $realFileCount++;
            }

        return $this->render('search',[
            'model' => $model,
            'files' => $files,
            'realFileCount' => $realFileCount
        ]);
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    //отключение валидации при Ajax
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


}