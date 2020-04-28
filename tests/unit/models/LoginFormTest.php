<?php

namespace app\tests\unit\models;

use app\tests\fixtures\UserFixture;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    //тестируем функцию логина
    // tests
    public function testLogin()
    {
        $loginForm = new \app\models\LoginForm([
            'username' => 'test_user',
            'password' => 'test_user'
        ]);

        expect($loginForm->login())->true();
    }

    public function testValidate()
    {
        $loginForm = new \app\models\LoginForm([
            'username' => 'test_user',
            'password' => 'test_user'
        ]);

        expect($loginForm->validate())->true();
    }

    public function testWrongValidate()
    {
        $loginForm = new \app\models\LoginForm([
            'username' => '',
            'password' => '5'
        ]);

        $this->assertFalse($loginForm->validate(), 'validate is wrong');
        $this->assertArrayHasKey('username', $loginForm->getErrors(), 'username is wrong');
        $this->assertArrayHasKey('password', $loginForm->getErrors(), 'password is wrong');
    }


}