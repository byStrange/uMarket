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
            [['id', 'product_id', 'category_id', 'image_banner_id', 'image_portrait_id', 'image_small_landscape_id'], 'integer'],
            [['created_at', 'updated_at', 'start_time', 'end_time', 'type'], 'safe'],
            [['dicount_price'], 'number'],
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
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'dicount_price' => $this->dicount_price,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'image_banner_id' => $this->image_banner_id,
            'image_portrait_id' => $this->image_portrait_id,
            'image_small_landscape_id' => $this->image_small_landscape_id,
        ]);

        $query->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
