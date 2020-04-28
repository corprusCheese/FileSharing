<?php

namespace app\tests\unit\models;

use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
use Yii;

class CommentFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(){
        return [
            'comments' => CommentFixture::className(),
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }

    public function testEmptyText(){
        $commentForm = new \app\models\CommentForm([
            'text' => '',
            'parentId' => '0'
        ]);

        expect($commentForm->validate())->false();
    }

    public function testNotEmptyText(){
        $commentForm = new \app\models\CommentForm([
            'text' => 'test',
            'parentId' => '0'
        ]);

        expect($commentForm->validate())->true();
    }

    public function testSaveAnsToFile(){
        $commentForm = new \app\models\CommentForm([
            'text' => 'test',
            'parentId' => '0'
        ]);
        $user = $this->tester->grabFixture('users','test_user');
        Yii::$app->user->login($user);
        expect($commentForm->saveComment(1))->true();
        Yii::$app->user->logout();
    }

    public function testSaveAnsToComment(){
        $commentForm = new \app\models\CommentForm([
            'text' => 'test',
            'parentId' => '1'
        ]);
        $user = $this->tester->grabFixture('users','test_user');
        Yii::$app->user->login($user);
        expect($commentForm->saveComment(1))->true();
        Yii::$app->user->logout();
    }
}