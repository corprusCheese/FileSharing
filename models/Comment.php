<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $number
 * @property string $path
 * @property string $text
 * @property string|null $date
 * @property int $fileId
 * @property string $user
 * @property int $parentId
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'path' => 'Path',
            'text' => 'Text',
            'date' => 'Date',
            'fileId' => 'File ID',
            'user' => 'User',
            'parentId' => 'Parent ID',
        ];
    }

    //для api
    public function fields(){
        return [
            'id',
            'parentId',
            'date',
            'text'
        ];
    }

    public static function getCommentById($id){

        return Comment::findOne(['id' => $id]);
    }

    public static function getChildren($fileId){
        $model = Comment::find()->where(['fileId'=>$fileId])->all();
        return $model;
    }

    public static function getSortedChildren($fileId){
        //выдает всех детей - отсортированные
        $model = Comment::find()->where(['fileId'=>$fileId])
            ->orderBy(['path'=>SORT_ASC])->all();
        return $model;
    }

    public function getFirstLineChildren(){
        //выдает всех детей первого порядка
        $children = Comment::find()->where("parentId = :pId",[':pId' => $this->id])
            ->orderBy('path')->all();
        return $children;
    }

    public function getLastChild(){
        //возвращает последнего ребенка первого порядка
        //так как они уже отсортированы, берем последнего ребенка
        $firstLine = $this->getFirstLineChildren();
        if ($firstLine) {
            return end($firstLine);
        }
        else
            return null;
    }

    public function getEncodedText(){
        return Html::encode($this->text);
    }

    public function getEncodedUser(){
        return Html::encode($this->user);
    }

    public function deleteComment(){

        $children = Comment::find()->where("path like CONCAT(:p,'.%')",[':p' => $this->path])->all();
        //print_r($children);

        foreach ($children as $i)
            $i->delete();
        $this->delete();

    }
}