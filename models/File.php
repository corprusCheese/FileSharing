<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property float $size
 * @property string $downloadDate
 * @property string|null $extension
 * @property string $userAuthKey
 *
 * @property User $userAuthKey0
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'size' => 'Размер',
            'downloadDate' => 'Дата загрузки',
            'extension' => 'Расширение',
            'userAuthKey' => 'User Auth Key',
        ];
    }

    //для api
    public function fields(){
        return [
            'id',
            'fullName',
            'size',
            'downloadDate',
            'comments'
        ];
    }

    //получить полное имя файла
    public function getFullName(){
        return $this->name.'.'.$this->extension;
    }

    public function getUsername()
    {
        return User::findUserByAuth($this->userAuthKey)->username;
    }

    //получить все комменты

    public function getComments(){
        return $this->hasMany(Comment::className(),['fileId'=>'id']);
    }

    //остальное
    //получить путь к папке с файлом
    public static function getFolder($file, $absolute = false){
        if ($absolute==false) {
            $path = Yii::$app->request->baseUrl . '\..\uploads\\';//\..
        }
        else{
            $path = Yii::$app->basePath. '\web\uploads\\';//\.
        }
        $music = array('mp3','flac','aac','m4a','wav','wma', 'oga', 'alac');
        $image = array('bmp','jpg','jpeg','gif','png');
        $video = array('webm','mp4','ogv','flv');

        if (in_array($file->extension, $music)) {
            $path .= 'music';
        }
        elseif (in_array($file->extension, $image)){
            $path .= 'image';
        }
        elseif (in_array($file->extension, $video)) {
            $path .= 'video';
        }
        else{
            $path.='other';
        }
        return $path;
    }

    public static function getFileById($id){
        if (gettype($id)=='string'){
            settype($id, 'integer');
        }
        return File::findOne(['id' => $id]);
    }

    public static function getNextId(){
        return File::find()->max('id') + 1;
    }

    public static function getLastDownloadDate(){
        return File::find()->max('downloadDate');
    }
}