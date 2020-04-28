<?php

namespace app\tests\functional;

use app\tests\fixtures\UserFixture;

class RegisterFormCest
{
    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function _before(\FunctionalTester $I){
        $I->amOnPage(['site/register']);
    }

    public function testThatThereIsNoFlash(\FunctionalTester $I)
    {
        $I->dontSee('Пользователь с таким именем или email уже есть в базе');
    }

    public function testThatThereIsNoFlashAfterSubmit(\FunctionalTester $I)
    {
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user1',
            'RegisterForm[email]' => 'test_user1@yandex.ru',
            'RegisterForm[password]' => 'test_user',]);
        $I->dontSee('Пользователь с таким именем или email уже есть в базе');
    }

    public function testThatThereIsFlashAfterSubmit(\FunctionalTester $I)
    {
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user',
            'RegisterForm[email]' => 'test_user@yandex.ru',
            'RegisterForm[password]' => 'test_user',]);
        $I->see('Пользователь с таким именем или email уже есть в базе');
    }

    public function testSmallPassword(\FunctionalTester $I)
    {
        //больше равно 6
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user434',
            'RegisterForm[password]' => 'test',
            'RegisterForm[email]' => 'test_user123@yandex.ru',
            ]);
        $I->see('Пароль should contain at least 6 characters.');
    }

    public function testWrongEmail(\FunctionalTester $I)
    {
        //больше равно 6
        $I->submitForm('#register-form', ['RegisterForm[username]' => 'test_user434',
            'RegisterForm[password]' => 'test',
            'RegisterForm[email]' => 'test_use',
        ]);
        $I->see('Email is not a valid email address.');
    }
}
