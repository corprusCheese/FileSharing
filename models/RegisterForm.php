<?php


namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            ['username','trim'],
            ['username', 'required'],
            ['username', 'string'],

            ['email', 'trim'],
            ['email','required'],
            ['email','email'],

            ['password', 'required'],
            ['password','string','min' => 6]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Email'
        ];
    }

    public function save(){
        if ($this->validate()){
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->authKey = Yii::$app->security->generateRandomString();
            $user->password = Yii::$app->security->generatePasswordHash($this->password);

            return $user->save();
        }
        else return false;
    }

}