<?php
namespace Page;

use Yii;

class LoginPage
{
    public static function route($param)
    {
        return Yii::$app->getUrlManager()->createUrl('').'site/login'
            .$param;
    }
    /**
     * @var \AcceptanceTester;
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    public function auth(){
        //логинимся
        $this->tester->amOnPage(self::route(''));
        $this->tester->submitForm('#login-form', ['LoginForm[username]' => 'test_user',
            'LoginForm[password]' => 'test_user',]);
        $this->tester->wait(3);
    }
}
