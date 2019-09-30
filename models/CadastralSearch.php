<?php

namespace alhimik1986\bftcadastral\models;

use Exception;
use app\modules\cadastral\services\CadastralMap;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cadastral\models\Cadastral;

/**
 * CadastralSearch represents the model behind the search form of `app\modules\cadastral\models\Cadastral`.
 */
class CadastralSearch extends Cadastral
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'area'], 'integer'],
            [['cadastral_number', 'address'], 'string'],
            [['price'], 'number'],
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
     * @param array $params
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function search($params)
    {
        $dataProvider = new ActiveDataProvider();

        $this->load($params);

        if (!$this->validate() OR ! $this->cadastral_number) {
            $dataProvider->setModels([]);
            $dataProvider->setTotalCount(0);
            return $dataProvider;
        }

        $cadMap = new CadastralMap();
        $models = $cadMap->getDataByCadNumbers($this->cadastral_number, false);
        $dataProvider->setModels($models);
        $dataProvider->setTotalCount(count($models));

        return $dataProvider;
    }
}
