<?php


namespace app\models;


use Yii;
use yii\base\Model;
use app\models;
use yii\helpers\HtmlPurifier;

class CommentForm extends Model
{
    public $text;
    public $parentId;

    public function rules()
    {
        return [
            [['text','parentId'], 'required'],
        ];
    }

    public function saveComment($fileId){

        // MaterializedPath
        $comment = new Comment();

        //сами данные
        $comment->text = $this->text;
        $time = time();
        $time += 3 * 3600;
        $comment->date = date("Y-m-d H:i:s",$time);
        $comment->fileId = $fileId;
        $comment->user=User::findIdentity(Yii::$app->user->identity->getId())->username;
        $comment->parentId = $this->parentId;

        if ($this->parentId==0){
            //это значит что обращается к главному посту
            //в базе хранятся только комментарии
            //поэтому мы не можем получить родительский коммент
            //но мы можем присвоить ему id = 0
            $parentComment = new Comment();
            $parentComment->id = 0;
        }
        else {
            //получает родительский коммент, если this->parentid не 0
            $parentComment = Comment::getCommentById($this->parentId);
        }
        //получает ребенка первого уровня с самым большим путем (или null)
        $lastchild = $parentComment->getLastChild();

        if ($lastchild){
            $comment->number = $lastchild->number+1;
            $zeroes = $comment->number;

            //с точкой если есть вложенность
            if ($this->parentId==0) {
                $path = $parentComment->path;
            }
            else{
                $path = $parentComment->path . '.';
            }

            // path вида 001.001.002
            if ($zeroes<10){
                $path = $path.'00'.$zeroes;
            }
            elseif($zeroes>=10 && $zeroes<100){
                $path = $path.'0'.$zeroes;
            }
            elseif($zeroes>=100 && $zeroes<1000){
                $path = $path.$zeroes;
            }

            $comment->path = $path;
        }
        else{
            $comment->number = 1;
            if ($this->parentId==0) {
                $comment->path ='001';
            }
            else {
                $comment->path = $parentComment->path . '.001';
            }
        }

        return $comment->save();
    }
}