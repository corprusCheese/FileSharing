<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $admin = $auth->createRole('admin');
        $my_user = $auth->createRole('my_user');

        $auth->add($admin);
        $auth->add($my_user);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAllFiles = $auth->createPermission('allFiles');
        $viewAllFiles->description = 'Управление всеми файлами файлообменника';

        $auth->add($viewAllFiles);

        $auth->addChild($admin, $my_user);
        $auth->addChild($admin, $viewAllFiles);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);
    }

    public function actionCreateAdmin(){
        if (!User::find()->where(['id'=>1])->exists())
            $pass = Yii::$app->security->generatePasswordHash('admin');
        $auth = Yii::$app->security->generateRandomString();
        $command = Yii::$app->db->createCommand("INSERT INTO user VALUES(1,'admin',:p,:a,'admin@yandex.ru')");
        $command->bindParam(':p', $pass);
        $command->bindParam(':a',$auth);
        $command->execute();
    }
}
