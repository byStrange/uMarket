<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["id", "coupon_id", "user_id", "address_id"], "integer"],
            [["created_at", "updated_at", "status", "payment_type"], "safe"],
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
        $query = Order::find();

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
            "coupon_id" => $this->coupon_id,
            "user_id" => $this->user_id,
            "address_id" => $this->address_id,
        ]);

        $query
            ->andFilterWhere(["ilike", "status", $this->status])
            ->andFilterWhere(["ilike", "payment_type", $this->payment_type]);

        return $dataProvider;
    }
}
