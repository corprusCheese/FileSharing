<?php


namespace app\models;

use app\other\SphinxCmdHelper;
use app\other\SphinxHelper;
use Yii;
use yii\base\Model;
use app\models\User;
use yii\sphinx\Connection;
use yii\sphinx\Query;

class SearchForm extends Model{

    public $searchText;

    public function rules()
    {
        return [
            ['searchText','trim'],
            ['searchText', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'searchText' => 'Поисковая строка'
        ];
    }

    public function search(){

        if (!$this->searchText)
            return null;

        if ($this->validate()){

            $data = SphinxHelper::queryIdx($this->searchText);
            $dataMain = SphinxHelper::queryMainIdx($this->searchText);
            if (count($data)==count($dataMain))
                //удаляет реал тайм таблицу, если индексы перезагружены
                SphinxHelper::deleteAllRt();

            return $data;
        }
    }
}