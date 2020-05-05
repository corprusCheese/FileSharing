<?php

use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use kartik\file\fileinput;
use yii\helpers\Url;
/* @var $model \app\models\FileForm */

$this->title = 'Главная страница (admin)';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if(!Yii::$app->user->isGuest):?>
<div class="anime">
<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-xl-offset-2" style="margin-top: 100px">
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]);
?>
    <?= $form->field($model, 'files[]')->widget(FileInput::className(),[
            'name' => 'attach[]',
            'options' =>
                [
                    'multiple' => true
                ],
            'pluginOptions' =>
                [
                    'showUpload' => true,
                    'previewFileType' => 'any',
                    'uploadUrl' => Url::to(['site/uploads']),
                    'encodeUrl' => false,
                    'layoutTemplates' => [
                        'progress' => '',
                    ],
                ],
            'language' => 'ru',
        ]
    ); ?>

<?php ActiveForm::end(); ?>
</div></div>
<?php endif;?>