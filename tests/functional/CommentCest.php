<?php

namespace app\tests\functional;

use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
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

    public function testSeeComments(\FunctionalTester $I){
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->see('Text');
    }

    public function testSeeFile(\FunctionalTester $I){
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->see('dummy.txt');
    }

    public function testSeeDeleteIfNotGuest(\FunctionalTester $I){

        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->seeElement('.comment-buttons');
    }

    public function testSeeDeleteIfGuest(\FunctionalTester $I){
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->dontSeeElement('.comment-buttons');
    }

    public function testDoDeleteIfNotGuest(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->seeElement('.other-comment');
        $I->click('a[name=deleteButton1]');
        $I->amOnPage(['file/view', 'id'=>'1']);
        $I->dontSeeElement('.other-comment');
    }
}
