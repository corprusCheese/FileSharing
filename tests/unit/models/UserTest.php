<?php

namespace app\tests\unit\models;

use app\tests\fixtures\UserFixture;
use UnitTester;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function _fixtures(){
        return ['users' => UserFixture::className()];
    }

    public function testGetId(){
        $user = $this->tester->grabFixture('users','test_user');
        expect($user->getId())->equals(1);
    }

    public function testGetAuthKey(){
        $user = $this->tester->grabFixture('users','test_user');
        expect($user->getAuthKey())->equals('randomAuthKey');
    }

    public function testValidatePassword(){
        $user = $this->tester->grabFixture('users','test_user');
        $userPassword = 'test_user';
        expect($user->validatePassword($userPassword))->equals(true);
    }

    public function testValidateAuth(){
        $user = $this->tester->grabFixture('users','test_user');
        $userAuth = 'randomAuthKey';
        expect($user->validateAuthKey($userAuth))->equals(true);
    }
}