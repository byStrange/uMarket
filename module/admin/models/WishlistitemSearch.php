<?php

namespace app\module\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wishlistitem;

/**
 * WishlistitemSearch represents the model behind the search form of `app\models\Wishlistitem`.
 */
class WishlistitemSearch extends Wishlistitem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cart_id', 'product_id'], 'integer'],
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
        $query = Wishlistitem::find();

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
            'cart_id' => $this->cart_id,
            'product_id' => $this->product_id,
        ]);

        return $dataProvider;
    }
}
