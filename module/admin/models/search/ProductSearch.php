<?php

namespace app\module\admin\models\search;

use app\components\Utils;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
  public $category_id;
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["id", "views", "created_by_id"], "integer"],
      [["created_at", "updated_at", "status"], "safe"],
      [["price", "discount_price"], "number"],
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
    $query = Product::find()->active()->joinWith('categories');

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      "query" => $query,
    ]);


    if ($this->category_id) {
      $query->andWhere(['main_category.id' => $this->category_id]);
    }

    $this->load($params);

    if (!$this->validate()) {
      Utils::printAsError('fuckjl');
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      "id" => $this->id,
      "created_at" => $this->created_at,
      "updated_at" => $this->updated_at,
      "price" => $this->price,
      "discount_price" => $this->discount_price,
      "views" => $this->views,
      "is_deleted" => $this->is_deleted,
      "created_by_id" => $this->created_by_id,
    ]);

    $query->andFilterWhere(["ilike", "status", $this->status]);

    return $dataProvider;
  }
}
