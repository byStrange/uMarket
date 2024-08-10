<?php

namespace app\module\admin\controllers;

use app\models\FeaturedOffer;
use app\models\Order;
use app\models\Product;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
  /**
   * Renders the index view for the module
   * @return string
   */
  public function actionIndex()
  {
    $totalOrders = Order::find()->count();
    $totalProducts = Product::find()->active()->count();
    $featuredOffers = FeaturedOffer::find()->count();
    $activeUsers = User::find()->where(['is_active' => true])->count();

    $recentOrdersProvider = new ActiveDataProvider([
      'query' => Order::find()->orderBy(['created_at' => SORT_DESC]),
      'pagination' => [
        'pageSize' => 5,
      ],
    ]);

    return $this->render('index', [
      'totalOrders' => $totalOrders,
      'totalProducts' => $totalProducts,
      'featuredOffers' => $featuredOffers,
      'activeUsers' => $activeUsers,
      'recentOrdersProvider' => $recentOrdersProvider,
    ]);
  }
}
