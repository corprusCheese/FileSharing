<?php

namespace app\modules\admin\models;

use app\models\File;
use app\models\User;
use yii\web\UploadedFile;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class FileSearch extends File
{
    //вычисляемое поле
    public $fullName;
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'downloadDate', 'extension', 'userAuthKey'], 'safe'],
            [['size'], 'number'],
            [['fullName'], 'safe'],
            [['downloadDate'], 'string'],
            [['username'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = File::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[
                'pageSize' => 10
            ]
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'fullName' => [
                    'asc' => ['name' => SORT_ASC, 'extension' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC, 'extension' => SORT_DESC],
                    'label' => 'fullName',
                    'default' => SORT_ASC
                ],
                'username',
                'size',
                'downloadDate'
            ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        Yii::$app->user->identity->getAuthKey();

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'downloadDate' => $this->downloadDate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'userAuthKey', $this->userAuthKey])
            ->andFilterWhere(['like', 'size',$this->size])
            ->andWhere('name LIKE "%' . $this->fullName . '%" ' .
                'OR extension LIKE "%' . $this->fullName . '%"' .
                'OR CONCAT(name,".",extension) LIKE"%' . $this->fullName . '%"'
            )
        ->andFilterWhere(['like', 'downloadDate',$this->downloadDate]);
        return $dataProvider;
    }
}

