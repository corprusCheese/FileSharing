<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\modules\admin\models\FileSearch */

$this->title = 'Загруженные файлы';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= $this->title?></h3>

<?php Pjax::begin(); ?>

<?=\yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'fullName',
                'label'=>'Имя файла',
                'contentOptions' => ['style' => 'width: 50px']
            ],
            [
                'attribute'=>'username',
                'label'=>'Пользователь',

                'contentOptions' => ['style' => 'width: 50px']
            ],
            [
                'attribute'=>'size',
                'label'=>'Размер файла',
                'value'=>function($model){
                    return $model->size.' Кб';
                },
                'contentOptions' => ['style' => 'width: 50px']
            ],
            [
                 'attribute'=>'downloadDate',
                 'label'=>'Дата загрузки',
                 'contentOptions' => ['style' => 'width: 50px']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '30'],
                'template' => '{view} {download} {delete}',
                'buttons' => [
                        'view' => function($url,$model, $key){
                            $iconName = "eye-open";
                            $icon = Html::tag('span', '',
                                ['class' => "glyphicon glyphicon-$iconName"]);
                            $url = Url::to(['file/view','id'=>$model->id]);
                            return Html::a($icon, $url, ['name' => 'viewButton'.$model->id]);
                        },
                        'delete' => function($url, $model, $key){
                            $iconName = "trash";
                            $icon = Html::tag('span', '',
                                ['class' => "glyphicon glyphicon-$iconName"]);
                            $url = Url::to(['file/delete','id'=>$model->id]);
                            return Html::a($icon, $url, ['name' => 'deleteButton'.$model->id]);
                        },
                        'download' => function($url, $model, $key){
                            $iconName = "download-alt";
                            $icon = Html::tag('span', '',
                                ['class' => "glyphicon glyphicon-$iconName"]);
                            $url = Url::to(['file/download','id'=>$model->id]);
                            return Html::a($icon, $url, ['name' => 'downloadButton'.$model->id,'data-pjax'=>'0']);
                        },
                ]
            ]
        ]
]);
?>



<?php Pjax::end(); ?>
