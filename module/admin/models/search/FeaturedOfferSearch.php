<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FeaturedOffer;

/**
 * FeaturedOfferSearch represents the model behind the search form of `app\models\FeaturedOffer`.
 */
class FeaturedOfferSearch extends FeaturedOffer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    "id",
                    "image_banner",
                    "category_id",
                    "image_portrait",
                    "image_small_landscape",
                ],
                "integer",
            ],
            [
                ["created_at", "updated_at", "start_time", "end_time", "type"],
                "safe",
            ],
            [["discount"], "number"],
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
        $query = FeaturedOffer::find();

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
            "discount" => $this->discount,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "category_id" => $this->category_id,
            "image_banner" => $this->image_banner,
            "image_portrait" => $this->image_portrait,
            "image_small_landscape" => $this->image_small_landscape,
        ]);

        $query->andFilterWhere(["ilike", "type", $this->type]);

        return $dataProvider;
    }
}
