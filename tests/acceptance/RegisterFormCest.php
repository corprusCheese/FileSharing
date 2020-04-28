<?php

namespace app\tests\acceptance;

use app\tests\fixtures\UserFixture;
use Yii;

class RegisterFormCest
{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function _before(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/register');
    }

    public function testThatThereIsNoFlash(\AcceptanceTester $I)
    {
        $I->dontSee('Пользователь с таким именем или email уже есть в базе');
    }

    public function testThatThereIsNoFlashAfterSubmit(\AcceptanceTester $I)
    {
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user1',
            'RegisterForm[email]' => 'test_user1@yandex.ru',
            'RegisterForm[password]' => 'test_user',]);
        $I->wait(1);
        $I->dontSee('Пользователь с таким именем или email уже есть в базе');
    }

    public function testThatThereIsFlashAfterSubmit(\AcceptanceTester $I)
    {
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user',
            'RegisterForm[email]' => 'test_user@yandex.ru',
            'RegisterForm[password]' => 'test_user',]);
        $I->wait(2);
        $I->see('Пользователь с таким именем или email уже есть в базе');
    }

    public function testSmallPassword(\AcceptanceTester $I)
    {
        //больше равно 6
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user434',
            'RegisterForm[password]' => 'test',
            'RegisterForm[email]' => 'test_user123@yandex.ru',
            ]);
        $I->wait(1);
        $I->see('Пароль should contain at least 6 characters.');
    }

    public function testWrongEmail(\AcceptanceTester $I)
    {
        //больше равно 6
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user434',
            'RegisterForm[password]' => 'test',
            'RegisterForm[email]' => 'test_use',
        ]);
        $I->wait(1);
        $I->see('Email is not a valid email address.');
    }
}
