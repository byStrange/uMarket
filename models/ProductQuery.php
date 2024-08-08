<?php

namespace app\models;

use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
  public function active()
  {
    return $this->andWhere(['is_deleted' => 0]);
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
