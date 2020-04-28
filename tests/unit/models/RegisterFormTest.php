<?php

namespace app\tests\unit\models;

class RegisterFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testCorrectValues()
    {
        $registerForm = new \app\models\RegisterForm([
            'username' => 'user',
            'password' => 'user123',
            'email' => 'user@yandex.ru'
        ]);

        $this->assertTrue($registerForm->validate(), 'validate is nice');
    }

    public function testWrongValues(){

        $registerForm = new \app\models\RegisterForm([
            'username' => '',
            'password' => '',
            'email' => ''
        ]);

        $this->assertFalse($registerForm->validate(), 'validate is wrong');
        $this->assertArrayHasKey('username', $registerForm->getErrors(), 'username is wrong');
        $this->assertArrayHasKey('email', $registerForm->getErrors(), 'email is wrong');
        $this->assertArrayHasKey('password', $registerForm->getErrors(), 'password is wrong');
    }

    //надо проверить, что в базе уже есть такой логин
}