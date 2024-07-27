<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rating;

/**
 * RatingSearch represents the model behind the search form of `app\models\Rating`.
 */
class RatingSearch extends Rating
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["id", "score", "product_id", "user_id"], "integer"],
            [["created_at", "updated_at", "comment"], "safe"],
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
        $query = Rating::find();

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
            "score" => $this->score,
            "product_id" => $this->product_id,
            "user_id" => $this->user_id,
        ]);

        $query->andFilterWhere(["ilike", "comment", $this->comment]);

        return $dataProvider;
    }
}
