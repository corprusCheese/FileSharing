<?php

namespace app\tests\unit\models;

use app\models\File;
use app\tests\fixtures\FileFixture;

class FileTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(){
        return ['files' => FileFixture::className()];
    }

    // интеграционные тесты
    public function testGetFileById(){
        //$file = $this->tester->grabFixture('files','test_file');
        expect(File::getFileById(1))->isInstanceOf('app\models\File');
    }

    public function testGetNextId(){
        //два файла в фикстурах
        expect(File::getNextId())->equals(3);
    }

    public function testGetLastDownloadDate(){
        expect(File::getLastDownloadDate())->notEmpty();
    }

    //получить папку
    public function testGetFolder(){
        $file = $this->tester->grabFixture('files','test_file');
        //абсолютный путь
        $pathAbs = File::getFolder($file, true);
        expect(file_exists($pathAbs))->true();
        //относительный путь - костыль для того, чтобы выводило изображения во view
        //по некой причине абсолютные пути не работают для этого
        //также их тут проверить будет сложно, ибо там используется /../, тут вложенностей больше
        //а абсолютный используется для удаления, загрузки и сохранения
    }

}