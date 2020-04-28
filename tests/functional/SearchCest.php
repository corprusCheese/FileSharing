<?php

namespace app\tests\functional;

use app\other\SphinxHelper;
use app\tests\fixtures\FileFixture;
use Yii;
use yii\sphinx\Query;

class SearchCest{
    public function _fixtures(){
        return ['files' => FileFixture::className()];
    }

    public function _before(\FunctionalTester $I){
        $I->amOnPage(['site/search']);
    }

    // поиск работает со Sphinx
    // писать отдельные индексы для тестовой базы - муторно
    // но можно проверить по крайней мере вывод существующих
    /*
    public function testSearchJpg(\FunctionalTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => 'jpg']);
        $I->see('Найдено файлов в количестве');
        //$I->see('test_cat.jpg');
    }

    public function testSearchSmth(\FunctionalTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => 'smth']);
        $I->see('Не найдено ни одного файла');
    }*/

    public function testSearchEmpty(\FunctionalTester $I){

        $I->submitForm('#search-form', ['SearchForm[searchText]' => '']);
        $I->dontSee('Не найдено ни одного файла');
        $I->dontSee('Найдено файлов в количестве');
    }

}