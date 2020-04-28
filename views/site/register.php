<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">
    <h1><?= Html::encode($this->title)?></h1>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-xl-5">
            <?php $form = ActiveForm::begin(['id' => 'register-form']);?>

            <?= $form->field($model, 'username')->textInput(['autofocus'=>true]);?>

            <?= $form->field($model, 'password')->passwordInput();?>

            <?= $form->field($model, 'email')->textInput();?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрировать',
                    [ 'class' =>'btn btn-primary', 'name' =>'login-button' ]) ?>
            </div>

            <?php ActiveForm::end();?>
        </div>

    </div>
</div>