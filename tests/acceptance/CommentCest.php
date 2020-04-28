<?php

namespace app\tests\acceptance;

use app\models\Comment;
use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
use Helper\Acceptance;
use Page\LoginPage;
use yii\helpers\Url;
use Yii;

class CommentCest
{
    public function _fixtures(){
        return [
            'comments' => CommentFixture::className(),
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }
    /*
    public static function _before(\AcceptanceTester $I){
        // pretty print отключен
        // если писать контроллер, он использует не тестовую базу
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
    }
    */

    public function testSeeComments(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
        $I->see('Text');
    }

    public function testSeeDeleteIfGuest(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
        $I->wait(2);
        $I->dontSeeElement('.comment-buttons');
    }

    public function testSeeDeleteIfNotGuest(\AcceptanceTester $I){

        $page = new LoginPage($I);
        $page->auth();
        $I->wait(2);
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
        $I->seeElement('.comment-buttons');
    }

    public function testDoDeleteIfNotGuest(\AcceptanceTester $I){
        $page = new LoginPage($I);
        $page->auth();
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
        $I->seeElement('.other-comment');
        $I->click('a[name=deleteButton1]');
        //$I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'comment/delete&id=1');
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'file/view&id=1');
        $I->dontSeeElement('.other-comment');
    }
}
