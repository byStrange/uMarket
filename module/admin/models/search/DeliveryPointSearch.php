<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeliveryPoint;

/**
 * DeliveryPointSearch represents the model behind the search form of `app\models\DeliveryPoint`.
 */
class DeliveryPointSearch extends DeliveryPoint
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["id", "location_id"], "integer"],
            [["created_at", "updated_at", "label"], "safe"],
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
        $query = DeliveryPoint::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            "query" => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            "id" => $this->id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "location_id" => $this->location_id,
        ]);

        $query->andFilterWhere(["ilike", "label", $this->label]);

        return $dataProvider;
    }
}
