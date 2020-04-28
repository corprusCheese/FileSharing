<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Войти';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title)?></h1>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-xl-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']);?>

            <?= $form->field($model, 'username')->textInput(['autofocus'=>true])->label(true);?>

            <?= $form->field($model, 'password')->input('password');?>

            <div class="form-group">
                <?= Html::submitButton('Войти',
                    [ 'class' =>'btn btn-primary', 'name' =>'login-button' ]) ?>
            </div>

            <?php ActiveForm::end();?>
        </div>

    </div>
</div>