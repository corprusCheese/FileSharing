<?php

namespace app\tests\acceptance;

use app\tests\fixtures\UserFixture;
use Page\LoginPage;
use Yii;

class IndexCest{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function testGuest(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/index');
        $I->dontSeeElement('.form-group');
    }


    public function testEnter(\AcceptanceTester $I){
        $page = new LoginPage($I);
        $page->auth();
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/index');
        $I->seeElement('.anime');
    }
}