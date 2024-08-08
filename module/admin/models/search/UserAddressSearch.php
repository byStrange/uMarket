<?php

namespace app\module\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserAddress;

/**
 * UserAddressSearch represents the model behind the search form of `app\models\UserAddress`.
 */
class UserAddressSearch extends UserAddress
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["id", "user_id"], "integer"],
      [["created_at", "updated_at", "label", "city", "zip_code"], "safe"],
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
    $query = UserAddress::find();

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
      "user_id" => $this->user_id,
    ]);

    $query
      ->andFilterWhere(["ilike", "label", $this->label])
      ->andFilterWhere(["ilike", "city", $this->city])
      ->andFilterWhere(["ilike", "zip_code", $this->zip_code]);

    return $dataProvider;
  }
}
