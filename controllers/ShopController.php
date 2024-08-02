<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use yii\web\Controller;

class ShopController extends Controller
{
    public function actionIndex()
    {
      return $this->render("index");
    }

    public function actionProduct($id, $d = false)
    {
    $product = Product::findOne(["id" => $id]);
    
    if ($d) {
      return $this->renderAjax('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => false]);
    }
      return $this->render("product-detail", ["product" => $product]);
    }
}
