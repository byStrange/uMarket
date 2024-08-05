<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\module\admin\models\search\ProductSearch;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class ShopController extends Controller
{
  public function actionIndex()
  {
    $searchModel = new ProductSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $pagination = new Pagination([
      'defaultPageSize' => 5,
      'totalCount' => $dataProvider->query->count(),
    ]);

    $products = $dataProvider->query->offset($pagination->offset)->limit($pagination->limit)->all();


    $totalCount = Product::find()->count();
    return $this->render("index", ['dataProvider' => $dataProvider, 'products' => $products, 'pagination' => $pagination, 'totalCount' => $totalCount, "searchModel" => $searchModel]);
  }

  public function actionProduct($id, $d = false)
  {
    $product = Product::findOne(["id" => $id]);

    if ($d) {
      return $this->renderAjax('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => false]);
    }
    return $this->render("product-detail", ["product" => $product]);
  }


  public function actionCategory($id)
  {
    $category = Category::findOne(['id' => $id]);
    $searchModel = new ProductSearch();
    $searchModel->category_id = $category->id;
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $totalCount = $dataProvider->query->count();

    /*var_dump($category);*/
    /*die;*/

    $pagination = new Pagination([
      'defaultPageSize' => 5,
      'totalCount' => $totalCount
    ]);

    $products = $dataProvider->query->offset($pagination->offset)->limit($pagination->limit)->all();

    return $this->render('category', ["category" => $category, "products" => $products, "pagination" => $pagination, "dataProvider" => $dataProvider, "totalCount" => $totalCount]);
  }
}
