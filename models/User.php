<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string|null $email
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'email' => 'Email',
        ];
    }

    public function rules()
    {
        return [
            ['username', 'unique'],
            ['email', 'unique'],
        ];
    }

    //для api
    public function fields(){
        return ['id', 'username', 'files','email'];
    }

    public function getFiles(){
        return $this->hasMany(File::className(),['userAuthKey'=>'authKey']);
    }

    //остальное
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public static function findUserByAuth($auth){
        return User::findOne(['authKey' => $auth]);
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password,$this->password);
    }
}
