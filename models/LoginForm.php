<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'trim'],
            ['password','validatePassword'],
            ['username','validateUsername'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = User::findByUsername($this->username);
            return Yii::$app->user->login($user);
        }
        return false;
    }

    public function validatePassword($attribute, $params)
    {
        $user = User::findByUsername($this->username);
        if (!$user){
            $this->addError($attribute,'Нет такого пользователя');
        }
        elseif (!$user->validatePassword($this->password)){
            $this->addError($attribute,'Пароль неверный');
        }
    }

    public function validateUsername($attribute, $params)
    {
        $user = User::findByUsername($this->username);
        if (!$user){
            $this->addError($attribute,'Нет такого пользователя');
        }
    }

}
