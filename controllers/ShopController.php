<?php

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;

class ShopController extends Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionProduct($id)
    {
        $product = Product::findOne(["id" => $id]);
        return $this->render("product-detail", ["product" => $product]);
    }
}
