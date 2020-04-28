<?php

use app\tests\fixtures\CommentFixture;
use app\tests\fixtures\FileFixture;
use app\tests\fixtures\UserFixture;

use app\models\FileForm;
use yii\web\UploadedFile;

class FileFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(){
        return [
            'comments' => CommentFixture::className(),
            'files' => FileFixture::className(),
            'users' => UserFixture::className()
        ];
    }

    // tests
    public function testValidateUploadedFile()
    {
        $fileForm = new FileForm();

        $uploadedFile = new UploadedFile();
        $uploadedFile->name = "test_cat.jpg";
        $uploadedFile->tempName = __DIR__."/../_data/test_cat.jpg";
        $uploadedFile->type = "image/jpg";
        $uploadedFile->size = 1024;

        $fileForm->files = array($uploadedFile);
        $this->assertTrue($fileForm->validate());
    }


    //C:\Sphinx\bin\indexer --all --config C:\Sphinx\sphinx.conf --rotate
    //перезапустить службу
    //rt таблица удаляется при следующем поиске
}