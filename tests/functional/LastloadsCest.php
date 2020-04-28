<?php

namespace app\tests\functional;

use app\models\User;
use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;

class LastloadsCest{
    public function _fixtures(){
        return [
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }

    public function testSeeItemForCertainUser(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['site/lastloads']);
        $I->see('dummy');
    }

    public function testSetFullName(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['site/lastloads']);
        $I->see('dummy.txt');
    }

    public function testDeleteButton(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['site/lastloads']);
        $I->click('a[name=deleteButton1]');
        $I->amOnPage(['site/lastloads']);
        $I->dontSee('dummy.txt');
    }

    public function testViewButton(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['site/lastloads']);
        $I->click('a[name=viewButton1]');
        $I->see('dummy.txt');
    }
    //хз как тестить download, ибо она таки может загрузить, но поврежденный файл
}