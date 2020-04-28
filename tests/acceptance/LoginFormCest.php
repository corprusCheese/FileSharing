<?php

namespace app\tests\acceptance;

use app\tests\fixtures\UserFixture;
use Yii;

class LoginFormCest
{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function _before(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/login');
    }

    public function testLoginWithEmptyCredentials(\AcceptanceTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => '',
            'LoginForm[password]' => '']);
        $I->wait(1);
        $I->see('Имя пользователя cannot be blank');
        $I->see('Пароль cannot be blank');
    }

    public function testWrongLogin(\AcceptanceTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => 'test_user434',
            'LoginForm[password]' => 'test_user2342',]);
        $I->wait(1);
        $I->see('Нет такого пользователя');
    }

    public function testRightLogin(\AcceptanceTester $I)
    {
        $I->submitForm('#login-form', ['LoginForm[username]' => 'test_user',
            'LoginForm[password]' => 'test_user',]);
        $I->wait(1);
        $I->dontSee('Нет такого пользователя');
        $I->dontSee('Неверный пароль');
    }


}
