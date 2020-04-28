<?php

namespace app\tests\acceptance;

use app\models\User;
use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;
use Page\LoginPage;
use Yii;

class LastloadsCest{
    public function _fixtures(){
        return [
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }

    public function _before(\AcceptanceTester $I){
        $page = new LoginPage($I);
        $page->auth();
        $I->wait(1);
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/lastloads');
    }

    public function testSeeFullNameItem(\AcceptanceTester $I){
        $I->see('dummy.txt');
    }

    public function testViewButton(\AcceptanceTester $I){
        $I->click('a[name=viewButton1]');
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/lastloads');
        $I->see('dummy.txt');
    }

    public function testDeleteButton(\AcceptanceTester $I){
        $I->click('a[name=deleteButton1]');
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/lastloads');
        $I->dontSee('dummy.txt');
    }
    //хз как тестить download, ибо она таки может загрузить, но поврежденный файл
}