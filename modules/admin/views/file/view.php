<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $model \app\models\File */
/* @var $filePath */
/* @var $commentModel \app\models\CommentForm */
/* @var $this \yii\web\View */

/** @var app\models\User $userModel */
/** @var app\models\Comment[] $fileComments */
//идентити зашедшего
$userModel = Yii::$app->user->identity;
//отсортированные как дерево комменты
$fileComments = Comment::getSortedChildren($model->id);
//имя загрузившего
$fileUploaderName = User::findUserByAuth($model->userAuthKey)->username;


$this->title = 'Файл';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-container">
    <div class="my-file">
    <?php if (strpos($filePath,'image')): ?>
        <?= Html::img($filePath,[
            'style' => 'max-width: 100%;height: auto;'
        ]);?>
     <?php elseif(strpos($filePath,'music')):?>
        <?= \app\other\HtmlHelper::JPlayerAudioHtml();?>
    <?php elseif (strpos($filePath,'video')):?>
        <div >
        <?= \app\other\HtmlHelper::JPlayerVideoHtml()?>
        </div>
    <?php elseif(strpos($filePath,'other')):
        $iconName = "download-alt";
        $icon = Html::tag('span', '',
            ['class' => "glyphicon glyphicon-$iconName"]);
        $url = Url::to(['file/download','id'=>$model->id,'data-pjax'=>0]);
        echo Html::a($icon." Нажмите на надпись, чтобы скачать и посмотреть", $url);
    endif; ?>

    </div>
    <div class="my-info" name="<?php echo ($model->name.'.'.$model->extension)?>">
        <?= "Имя файла: ".$model->name.'.'.$model->extension ?>
        <br>
        <?= "Размер файла: ".$model->size.'Кб' ?>
        <br>
        <?= "Дата загрузки файла: ".$model->downloadDate ?>
        <br>
        <?= "Имя загрузившего пользователя: ".$fileUploaderName?>
        <br>
    </div>
    <?= Html::submitButton('Прокомментировать файл',
        [ 'class' =>'btn btn-primary', 'name' =>'answer-button','id' => 0 ]) ?>
</div>

<?php if($fileComments): ?>
<h4 style='font-family: "Times New Roman"'>Комментарии</h4>
<?php foreach($fileComments as $comment):?>
    <?php if ($comment->parentId==0){?>
    <div class="other-comment">
    <?php } else {?>
    <div class="other-comment" style="margin-left: 40px">
    <?php }?>
        <?php
        if ($comment->parentId==0){
            $parent = new Comment();
            $parent->user = $fileUploaderName;
            $parent->date = $model->downloadDate;
        }
        else{
            $parent = Comment::getCommentById($comment->parentId);
        }
        ?>
        <h6 style="font-weight: bold">Пользователь <?=$comment->getEncodedUser()?> (<?=$comment->date?>) ответил пользователю <?=$parent->getEncodedUser()?> (<?=$parent->date?>)</h6>
        <p class="comment-text"><?=nl2br($comment->getEncodedText())?></p>

        <?= Html::submitButton('Ответить',
        [ 'class' =>'btn btn-primary', 'name' =>'answer-button', 'id' => $comment->id ]) ?>
        <div class="comment-buttons">
            <a href=<?=Url::to(['comment/delete','id'=>$comment->id])?>
               name=<?="deleteButton".$comment->id?>>
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        </div>
    </div>
<?php endforeach; ?>
<?php endif;?>
<br><br><br><br>
<?php if (!Yii::$app->user->isGuest):?>
<div class="leave-comment">
    <h5>Ваш комментарий</h5>
    <?php $form = ActiveForm::begin([
            'id' => 'comment-form',]);?>
    <div class="form-group">
        <div class="col-md-12">
            <?= $form->field($commentModel, 'text')->textarea(['class'=>'form-control',
                'placeholder' =>'Текст комментария...'])
                ->label(''.\yii\helpers\Html::encode($userModel->username).'')?>
            <?= $form->field($commentModel, 'parentId')->hiddenInput()->label(false)?>
        </div>

        <?= Html::submitButton('Прокомментировать',
            [ 'class' =>'btn btn-primary', 'name' =>'post-button']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>
<?php endif;?>