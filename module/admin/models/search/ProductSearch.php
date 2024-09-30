<?php

namespace app\module\admin\models\search;

use app\components\Utils;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;
use yii\data\ArrayDataProvider;

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
      [["brand"], "string", "max" => 255]
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
  public function search($params, $showAll = false)
  {
    $query = Product::find()->joinWith('category');

    if (!$showAll) {
      $query->andWhere(['is_deleted' => false, 'status' => [Product::STATUS_PUBLISHED, Product::STATUS_OUT_OF_STOCK]]);
    }

    $dataProvider = new ActiveDataProvider([
      "query" => $query,
    ]);


    if ($this->category_id) {
      $query->andWhere(['main_category.id' => $this->category_id]);
    }

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      "id" => $this->id,
      "brand" => $this->brand,
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

  public function searchArray($params, $showAll = false)
  {
    $products = Product::find()->effective_products_list($params); // actual products list data
    $query = Product::find()->joinWith('category');

    if (!$showAll) {
      $products = array_filter($products, function ($product) {
        return !$product->is_deleted && in_array($product->status, [Product::STATUS_PUBLISHED, Product::STATUS_OUT_OF_STOCK]);
      });
    }

    $this->load($params);
    $dataProvider = new ActiveDataProvider([
      "query" => $query,
    ]);


    if ($this->category_id) {
      $query->andWhere(['main_category.id' => $this->category_id]);
    }

    $this->load($params);

    if (!$this->validate()) {
      return new ArrayDataProvider([
        'allModels' => [], // Return empty data if validation fails
        'pagination' => [
          'pageSize' => 10, // Set your desired page size
        ],
      ]);
    }

    $products = array_filter($products, function ($product) {
      // Apply filtering based on the model attributes
      return (
        ($this->id === null || $product->id == $this->id) &&
        ($this->brand === null || $product->brand == $this->brand) &&
        ($this->created_at === null || $product->created_at == $this->created_at) &&
        ($this->updated_at === null || $product->updated_at == $this->updated_at) &&
        ($this->price === null || $product->price == $this->price) &&
        ($this->discount_price === null || $product->discount_price == $this->discount_price) &&
        ($this->views === null || $product->views == $this->views) &&
        ($this->is_deleted === null || $product->is_deleted == $this->is_deleted) &&
        ($this->created_by_id === null || $product->created_by_id == $this->created_by_id) &&
        ($this->status === null || stripos($product->status, $this->status) !== false) // Using case-insensitive search
      );
    });

    // grid filtering conditions
    $dataProvider = new ArrayDataProvider([
      'allModels' => $products,
      'pagination' => [
        'pageSize' => 10, // Set your desired page size
      ],
      'sort' => [
        'attributes' => ['id', 'title', 'effective_price' => ['label' => 'Price']], // Specify the columns you want to sort by
      ],
    ]);

    return $dataProvider;
  }
}
