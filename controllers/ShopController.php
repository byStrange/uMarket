<?php

namespace app\controllers;

use app\components\Utils;
use app\models\Category;
use app\models\Product;
use app\models\Rating;
use app\models\User;
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

  public function actionProductView($id)
  {
    $this->response->format = \yii\web\Response::FORMAT_JSON;
    $user = Yii::$app->user->identity;
    $product = Product::findOne(["id" => $id, "is_deleted" => false, "status" => Product::VISIBLE_STATUSES]);

    if (!$product) {
      $this->response->statusCode = 404;
      return ['ok' => false, 'error' => "Product not found", "errorCode" => "NotFound", 'action' => 'viewProduct', 'data' => null];
    }

    $product->views = $product->views + 1;

    if ($user) {
      $is_user_viewer = $product->getViewers()->andWhere(['id' => $user->id])->exists();
      if (!$is_user_viewer) {
        $product->link('viewers', $user);
      }
    }

    $session = Yii::$app->session;
    if ($session->get('user_recently_viewed')) {
      $user_recently_viewed = $session->get('user_recently_viewed');
      if (!in_array($product->id, $user_recently_viewed)) {
        $user_recently_viewed[] = $product->id;
        $session->set('user_recently_viewed', $user_recently_viewed);
      }
    } else {
      $session->set('user_recently_viewed', [$product->id]);
    }

    $product->save();

    return ['ok' => true, 'action' => 'viewProduct', 'data' => $product];
  }

  public function actionProduct($id, $d = false)
  {
    $product = Product::findOne(["id" => $id, "is_deleted" => false, "status" => Product::VISIBLE_STATUSES]);
    $review_model = new Rating();

    /** @var User $user */
    $user = Yii::$app->user->identity;

    if ($this->request->isPost && $review_model->load($this->request->post())) {
      if ($user->hasRated($product->id)) {
        Yii::$app->session->setFlash('warn', "You have already rated this product");
        return $this->redirect(['product', 'id' => $product->id]);
      }

      $review_model->user_id = $user->id;
      $review_model->product_id = $product->id;

      if ($review_model->save()) {
        return $this->redirect(['product', 'id' => $product->id]);
      } else {
        return $this->redirect(['product', 'id' => $product->id]);
      }
    } else {
      $review_model->loadDefaultValues();
    }
    /*utils::printAsError($review_model->errors);*/

    if ($d) {
      return $this->renderPartial('@app/components/product/_product_detail_section', ["product" => $product, "detailed" => false]);
    }

    if (!$product) {
      return $this->render('@app/views/site/404');
    }

    return $this->render("product-detail", ["product" => $product, "review_model" => $review_model]);
  }



  public function actionCategory($id)
  {
    $category = Category::findOne(['id' => $id]);

    $searchModel = new ProductSearch();

    /*Utils::printAsError($category->id);*/
    $searchModel->category_id = $category->id;


    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $totalCount = $dataProvider->query->count();

    $dataProvider->pagination->pageSize = 5;

    $products = $dataProvider->getModels();

    return $this->render('category', ["category" => $category, "products" => $products, "pagination" => $dataProvider->pagination, "dataProvider" => $dataProvider, "totalCount" => $totalCount]);
  }

  public function actionCategories()
  {
    $categories = Category::find()->where(['parent_id' => null])->all();
    return $this->render('categories', ['categories' => $categories]);
  }
}
