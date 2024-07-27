<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LocationPoint;

/**
 * LocationPointSearch represents the model behind the search form of `app\models\LocationPoint`.
 */
class LocationPointSearch extends LocationPoint
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["id"], "integer"],
            [["created_at", "updated_at", "address_label"], "safe"],
            [["lon", "lat"], "number"],
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
        $query = LocationPoint::find();

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
            "lon" => $this->lon,
            "lat" => $this->lat,
        ]);

        $query->andFilterWhere([
            "ilike",
            "address_label",
            $this->address_label,
        ]);

        return $dataProvider;
    }
}
