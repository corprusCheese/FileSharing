<?php


namespace app\other;

use app\models\File;
use Yii;
use yii\sphinx\Connection;
use yii\sphinx\MatchExpression;
use yii\sphinx\Query;

//составляет запросы связанные с индексами Sphinx
class SphinxHelper{

    //запросы возвразают массивы с id, name, extension
    //для главного индекса
    private static function ifRealData(){
        $dbName = \app\other\DbHelper::getDbName('dbname',Yii::$app->getDb()->dsn);
        if ($dbName == 'filesharingdb')
            return 1;
        else return 0;
    }

    public static function queryMainIdx($searchText){
        if (self::ifRealData())
            return (new Query())->from('main_idx')->match($searchText)->all();
        else
            return (new Query())->from('main_idx_test')->match($searchText)->all();
    }

    //для реал тайм индекса
    public static function queryRtIdx($searchText){
        if (self::ifRealData())
            return (new Query())->from('rt_idx')->match($searchText)->all();
        else
            return (new Query())->from('rt_idx_test')->match($searchText)->all();
    }

    //для distributed индекса
    public static function queryIdx($searchText){
        if (self::ifRealData())
            return (new Query())->from('idx')->match($searchText)->all();
        else
            return (new Query())->from('idx_test')->match($searchText)->all();
    }

    //удаление всей таблицы реал тайм
    public static function deleteAllRt(){
        $deleteRtSql ='';
        if (self::ifRealData())
            $deleteRtSql = "DELETE FROM rt_idx WHERE id>=0";
        else
            $deleteRtSql = "DELETE FROM rt_idx_test WHERE id>=0";
        Yii::$app->sphinx->createCommand($deleteRtSql)->execute();
    }

    public static function deleteFromRt($id){
        $deleteRtSql ='';
        if (self::ifRealData())
            $deleteRtSql = "DELETE FROM rt_idx WHERE id=" . $id;
        else
            $deleteRtSql = "DELETE FROM rt_idx_test WHERE id=" . $id;
        Yii::$app->sphinx->createCommand($deleteRtSql)->execute();
    }

    //добавление в реал тайм элемента
    public static function saveFile($fileForSave){
        $saveRtSql = "";
        if (self::ifRealData())
            $saveRtSql = "INSERT INTO rt_idx(id, name, extension) VALUES
                    ('" . ($fileForSave->id) . "', '" . $fileForSave->name . "', '"
                . $fileForSave->extension .
                "')";
        else
            $saveRtSql = "INSERT INTO rt_idx_test(id, name, extension) VALUES
                    ('" . ($fileForSave->id) . "', '" . $fileForSave->name . "', '"
                . $fileForSave->extension .
                "')";

        Yii::$app->sphinx->createCommand($saveRtSql)->execute();
    }

    public static function queryRtIdxAll(){
        if (self::ifRealData())
            return (new Query())->from('rt_idx')->all();
        else
            return (new Query())->from('rt_idx_test')->all();
    }
}