<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage();?>
<html>
    <head>
        <title><?=$this->title?></title>
        <?php $this->head() ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php $this->beginBody();?>
        <?php
        \yii\bootstrap\NavBar::begin([
            'brandLabel' => 'FileSharing',
            'brandUrl' => ['/site/index'],
            'options' => [
                'class' => 'navbar-inverse navbar-static-top',
                'style' => 'background-color: whitesmoke'
            ]
        ]);
        $menuItems[] = ['label' => 'Главная', 'url' => ['/site/index']];
        //$menuItems[] = ['label' => 'Немного о сайте', 'url' => ['/site/about']];
        if (Yii::$app->user->isGuest){
            $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/register']];
        }
        else{
            $menuItems[] = ['label' => 'Выйти', 'url' => ['/site/logout']];
            $menuItems[] = ['label' => 'Мои файлы', 'url' => ['/site/lastloads']];
        }
        $menuItems[] = ['label' => 'Поиск', 'url' => ['/site/search']];
        echo \yii\bootstrap\Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems]);


        \yii\bootstrap\NavBar::end();
        ?>
        <div class="wrapper">
            <div class="container content" style="margin-top: 0px">
                <?= $content?>
            </div>
            <footer class="footer panel-footer"><!--Footer-->
                <div class="container">
                    <div class="row">
                        <p>Made by corprusCheese</p>
                    </div>
                </div>
            </footer>
        </div>
        <?php $this->endBody();?>
    </body>
</html>
<?php $this->endPage();?>