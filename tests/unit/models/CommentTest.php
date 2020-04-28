<?php

namespace app\tests\unit\models;

use app\models\Comment;
use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
use yii\helpers\Html;

class CommentTest extends \Codeception\Test\Unit
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

    // tests
    public function testGetCommentById(){

        //$comment = $this->tester->grabFixture('comments','test_comment');
        expect(Comment::getCommentById(1))->isInstanceOf('app\models\Comment');
    }

    public function testGetChildren(){
        //получает все комменты файла
        expect(Comment::getChildren(1))->count(3);
    }


    public function testGetSortedChildren(){
        //выдает всех детей - отсортированные
        $expected = array(
            $this->tester->grabFixture('comments','test_comment_0'),
            $this->tester->grabFixture('comments','test_comment_1'),
            $this->tester->grabFixture('comments','test_comment_2'),
        );

        expect(Comment::getSortedChildren(1))->equals($expected);
    }

    public function testGetFirstLineChildren(){
        //выдает всех детей первого порядка
        $expected = array(
            $this->tester->grabFixture('comments','test_comment_1'),
            $this->tester->grabFixture('comments','test_comment_2'),
        );

        $comment = $this->tester->grabFixture('comments','test_comment_0');
        expect($comment->getFirstLineChildren())->equals($expected);
    }

    public function testDeleteComment(){

        $comment = $this->tester->grabFixture('comments','test_comment_0');
        expect($comment->deleteComment())->isEmpty();
    }
}