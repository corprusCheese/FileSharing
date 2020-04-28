<?php

namespace app\tests\acceptance;

use app\models\File;
use app\other\SphinxHelper;
use app\tests\fixtures\FileFixture;
use Yii;
use yii\sphinx\Query;

class SearchCest{
    public function _fixtures(){
        return ['files' => FileFixture::className()];
    }

    public function _before(\AcceptanceTester $I){
        $I->amOnPage(Yii::$app->getUrlManager()->createUrl('').'site/search');
    }

    public function _after(\AcceptanceTester $I){
    }

    //в тестах не работаю запросы сохранения в test_idx
    //как придумаю как сохранять - напишу
    /*
    public function testSearchTxt(\AcceptanceTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => 'txt']);
        $I->wait(1);
        $I->see('Найдено файлов в количестве');
    }

    public function testSearchSmth(\AcceptanceTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => 'smth']);
        $I->wait(1);
        $I->see('Не найдено ни одного файла');
    }*/

    public function testSearchEmpty(\AcceptanceTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => '']);
        $I->wait(1);
        $I->dontSee('Не найдено ни одного файла');
        $I->dontSee('Найдено файлов в количестве');
    }

}