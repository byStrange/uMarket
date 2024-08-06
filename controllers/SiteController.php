<?php

namespace app\controllers;

use app\models\FeaturedOffer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Product;

class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      "access" => [
        "class" => AccessControl::class,
        "only" => ["logout", "account"],
        "rules" => [
          [
            "actions" => ["logout", "account"],
            "allow" => true,
            "roles" => ["@"],
          ],
        ],
      ],
      "verbs" => [
        "class" => VerbFilter::class,
        "actions" => [
          "logout" => ["post"],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      "error" => [
        "class" => "yii\web\ErrorAction",
      ],
      "captcha" => [
        "class" => "yii\captcha\CaptchaAction",
        "fixedVerifyCode" => YII_ENV_TEST ? "testme" : null,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    $products = Product::find()
      ->orderBy(["created_at" => SORT_DESC])
      ->limit(8)
      ->all();

    $famous8 = Product::getMostFamous8();
    $featuredOffers = FeaturedOffer::find()
      ->orderBy(["created_at" => SORT_DESC])
      ->all();

    return $this->render("index", [
      "products" => $products,
      "famous8" => $famous8,
      "featuredOffers" => $featuredOffers,
    ]);
  }

  /**
   * Login action.
   *
   * @return Response|string
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = "";
    return $this->render("login", [
      "model" => $model,
    ]);
  }
  public function actionAccount()
  {
    return $this->render("account");
  }
  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }

  public function actionCheckout() {
    return $this->render('checkout');
  }
}
