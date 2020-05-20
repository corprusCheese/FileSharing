<?php


namespace app\models;

use yii\web\UploadedFile;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class FileSearch extends File
{
    //вычисляемое поле
    public $fullName;
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
        ]);

        $query->andFilterWhere(['like', 'size',$this->size])
            ->andFilterWhere(['like', 'downloadDate',$this->downloadDate])
            ->andFilterWhere(['like','CONCAT(name,".",extension)',$this->fullName]);
        return $dataProvider;
    }
}

