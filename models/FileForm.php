<?php

namespace app\models;

use app\models\File;
use app\other\SphinxHelper;
use Yii;
use yii\base\Model;
use yii\sphinx\Query;
use yii\web\UploadedFile;
use app\models\Comment;

class FileForm extends Model{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules()
    {
        return [
            [['files'], 'file',
                'maxFiles' => 10],
        ];
    }

    public function upload(){

        if ($this->validate() && $this->files) {
            foreach ($this->files as $file) {

                $fileForSave = new File();
                $fileForSave->id = File::getNextId();
                $fileForSave->name = $file->baseName;
                $fileForSave->size = $file->size;

                $time = time();
                $time += 3 * 3600;
                $fileForSave->downloadDate = date("Y-m-d H:i:s",$time);//когда загружено, формат Datetime

                $fileForSave->extension = $file->extension;
                $fileForSave->userAuthKey = Yii::$app->user->identity->getAuthKey();

                $path = File::getFolder($fileForSave,true);
                if (!file_exists($path)) {
                    mkdir($path,0777, true);
                }
                $path .= '\\'.$file->baseName . '.' . $file->extension;

                //сохранение в реал тайм таблицу
                SphinxHelper::saveFile($fileForSave);
                //сохранение в базу и uploads
                $file->saveAs($path);
                $fileForSave->save();
            }
            return true;
        }
        else
            return false;
    }

}