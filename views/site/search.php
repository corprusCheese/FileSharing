<?php

use app\models\File;
use app\models\User;
use xj\jplayer\AudioWidget;
use xj\jplayer\VideoWidget;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $model \app\models\SearchForm */
/* @var $files \app\models\File[] */
/* @var $realFileCount int */
$this->title = 'Поиск файлов';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<h3 style="position: relative"><?= $this->title?></h3>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-xl-4" style=" min-width: 300px">
    <?php $form = \yii\widgets\ActiveForm::begin([
            'id' => 'search-form',
            'options' => ['data' => ['pjax' => true]],]);?>

    <?= $form->field($model, 'searchText')->textInput(['autofocus'=>true])->label(false);
        //->hint('введите имя или расширение файла',['style'=>'font-style: italic;']);?>

        <div class="form-group">
            <?= Html::submitButton('Найти',
                [ 'class' =>'btn btn-primary', 'name' =>'search-button' ]) ?>
        </div>

    <?php ActiveForm::end();?>

    </div>
    <br><br><br><br><br>
    <?php if(!$realFileCount && $model->searchText!=''): ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xl-6" style=" min-width: 300px">
             <div class="alert alert-danger alert-dismissable">
                 <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                 <?= 'Не найдено ни одного файла.'?>
             </div>
        </div>
    <?php elseif($realFileCount && $model->searchText!=''): ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-xl-6" style=" min-width: 300px">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= 'Найдено файлов в количестве '.$realFileCount.'.'?>
            </div>
        </div>
    <?php elseif($model->searchText==''): ?>
    <?php endif; ?>
</div>
<?php if ($files): ?>
    <?php foreach ($files as $file) : ?>
        <?php
        $file = \app\models\File::getFileById($file['id']);
        if ($file == null)
            continue;
        /*
        try {
            $file->name;
        }
        catch (Exception $e){
            continue;
        }*/
        $fileName = $file->name.'.'.$file->extension;
        $filePath = File::getFolder($file) .'\\' .$fileName;
        $fileUploaderName = User::findUserByAuth($file->userAuthKey)->username;
        ?>
        <div class="my-container">
            <div class="my-info">
                <?= "Имя файла: ".$file->name.'.'.$file->extension ?>
                <br>
                <?= "Размер файла: ".$file->size.'Кб' ?>
                <br>
                <?= "Дата загрузки файла: ".$file->downloadDate ?>
                <br>
                <?= "Имя загрузившего пользователя: ".$fileUploaderName?>
                <br>
            </div>
            <div class="file-buttons">
            <a href=<?="../file/view?id=".$file->id?>>
                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
            </a>
            <a href=<?="../file/download?id=".$file->id.'&data-pjax=0'?>>
                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
            </a>
            </div>
        </div>
    <?php endforeach;?>
<?php endif; ?>

<?php Pjax::end(); ?>
