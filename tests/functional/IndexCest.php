<?php

namespace app\tests\functional;

use app\tests\fixtures\UserFixture;

class IndexCest{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function testEnter(\FunctionalTester $I){
        $user = $I->grabFixture('users','test_user');
        $I->amLoggedInAs($user);
        $I->amOnPage(['site/index']);
        $I->seeElement('.form-group');
    }

    public function testGuest(\FunctionalTester $I){
        $I->amOnPage(['site/index']);
        $I->dontSeeElement('.form-group');
    }
}