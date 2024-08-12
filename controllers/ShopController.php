<?php

namespace app\controllers;

use app\components\Utils;
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

    // Set the page size
    $dataProvider->pagination->pageSize = 5;

    // Get the total count for all products (if needed)
    $totalCount = Product::find()->active()->count();

    // Fetch the products using the dataProvider
    $products = $dataProvider->getModels();

    return $this->render("index", [
      'dataProvider' => $dataProvider,
      'products' => $products,
      'pagination' => $dataProvider->pagination,
      'totalCount' => $totalCount,
      "searchModel" => $searchModel
    ]);
  }

  public function actionProduct($id, $d = false)
  {
    $product = Product::findOne(["id" => $id, "is_deleted" => false]);

    if ($d) {
      return $this->renderPartial('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => false]);
    }

    if (!$product) {
      return $this->render('@app/views/site/404');
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
    $pagination = new Pagination(['defaultPageSize' => 5, 'totalCount' => $totalCount]);
    $products = $dataProvider->query->offset($pagination->offset)->limit($pagination->limit)->all();
    return $this->render('category', ["category" => $category, "products" => $products, "pagination" => $pagination, "dataProvider" => $dataProvider, "totalCount" => $totalCount]);
  }

  public function actionCategories()
  {
    $categories = Category::find()->where(['parent_id' => null])->all();
    return $this->render('categories', ['categories' => $categories]);
  }
}
