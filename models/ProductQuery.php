<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
  public function active()
  {
    return $this->andWhere(['is_deleted' => 0,]);
  }

  public function effective_products_list(array $params = [], $order = "ASC", $extra_sql = "")
  {
    $sql = file_get_contents(Yii::getAlias('@app') . '/sample.sql');
    $maxPrice = isset($params["maxPrice"]) ? $params['maxPrice'] : null;
    $minPrice = isset($params['minPrice']) ? $params['minPrice'] : null;

    if ($minPrice) {
      $extra_sql = "WHERE effective_price > $minPrice";
    } else if ($maxPrice) {
      $extra_sql = "WHERE effective_price < $maxPrice";
    } else if ($minPrice && $maxPrice) {
      $extra_sql = "WHERE effective_price < $maxPrice AND effective_price > $minPrice";
    }

    $sql = str_replace("{{order_direction}}", $order, $sql);
    $sql = str_replace("{{extra_sql}}", $extra_sql, $sql);
    $data = Yii::$app->db->createCommand($sql)->queryAll();

    foreach ($data as &$product) {
      $product['asArray'] = true;
      $product = (object)($product);

      if (isset($product->translations) && !empty($product->translations)) {
        $product->translations = json_decode($product->translations, true);
      }
      if (isset($product->category_translations) && !empty($product->category_translations)) {
        $product->category_translations = json_decode($product->category_translations, true);
      }
      if (isset($product->images) && !empty($product->images)) {
        $product->images = json_decode($product->images, true);
        foreach ($product->images as &$image) {
          $image = (object)$image;
        }
        $ids = array_column($product->images, 'id');

        array_multisort($ids, SORT_ASC, $product->images);
      }
      if (isset($product->category) && !empty($product->category)) {
        $product->category = (object)json_decode($product->category, true);
      }
    }
    return $data;
  }

  // Override the all() method to apply the active filter by default
  public function all($db = null)
  {
    return parent::all($db);
  }

  // Override the one() method to apply the active filter by default
  public function one($db = null)
  {
    return parent::one($db);
  }
}
