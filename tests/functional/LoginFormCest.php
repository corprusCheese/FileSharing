<?php

namespace app\tests\functional;

use app\tests\fixtures\UserFixture;

class LoginFormCest
{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function _before(\FunctionalTester $I){
        $I->amOnPage(['site/login']);
    }

    public function testLoginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => '',
            'LoginForm[password]' => '']);
        $I->expectTo('see validations errors');
        $I->see('Имя пользователя cannot be blank');
        $I->see('Пароль cannot be blank');
    }


    public function testWrongLogin(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => 'test_user434',
            'LoginForm[password]' => 'test_user2342',]);
        $I->see('Нет такого пользователя');
    }

    public function testRightLogin(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => 'test_user',
            'LoginForm[password]' => 'test_user',]);
        $I->dontSee('Нет такого пользователя');
        $I->dontSee('Неверный пароль');
    }


}
