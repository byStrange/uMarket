<?php

namespace app\controllers;

use app\components\Utils;
use app\models\Cart;
use app\models\CartItem;
use app\models\Category;
use app\models\Coupon;
use app\models\FeaturedOffer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Order;
use app\models\OrderForm;
use app\models\Product;
use app\models\RegisterForm;
use app\models\User;
use app\models\UserAddress;
use PDO;
use yii\helpers\ArrayHelper;

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
      /*"error" => [*/
      /*"class" => "",*/
      /*],*/
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
      ->active()
      ->orderBy(["created_at" => SORT_DESC])
      ->limit(8)
      ->all();

    $pinned_categories = Category::find()
      ->where(['is_pinned' => true, 'parent_id' => null])
      ->orderBy(['id' => SORT_DESC])
      ->limit(3)
      ->all();

    $famous8 = Product::getMostFamous8();

    $featuredOffers = FeaturedOffer::activeOffers()
      ->orderBy(["created_at" => SORT_DESC])
      ->all();

    return $this->render("index", [
      "products" => $products,
      "famous8" => $famous8,
      "pinned_categories" => $pinned_categories,
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

      Cart::getOrCreateCurrentInstance();

      return $this->goBack();
    }

    $model->password = "";
    return $this->render("login", [
      "model" => $model,
    ]);
  }

  public function actionRegister()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new RegisterForm();
    /*Utils::printAsError(Yii::$app->request->post());*/
    if ($model->load(Yii::$app->request->post()) && $model->signup()) {
      /*Utils::printAsError('hellllo');*/
      Yii::$app->session->setFlash('success', 'Link sent to your email succesffully. Check your inbox or spam folder');
      return $this->redirect(['site/login']);
    }
    /*Utils::printAsError($model->errors);*/

    $model->password = "";
    $model->confirmPassword = "";
    return $this->render("signup", [
      "model" => $model
    ]);
  }

  public function actionAccount()
  {
    /** @var User $user */
    $user = Yii::$app->user->identity;
    $orders = $user->orders;

    return $this->render("account", ['orders' => $orders, 'user' => $user]);
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

  public function actionDeleteUseraddress()
  {
    $this->response->format = Response::FORMAT_JSON;
    $id = $this->request->getBodyParam('id');
    $user = Yii::$app->user;
    if (!$id) {
      return ['ok' => false, 'message' => 'id: this field is required', 'action' => 'deleteUserAddress'];
    }

    $user_address = UserAddress::findOne(['id' => $id]);
    if (!$user_address) {
      return ['ok' => false, 'message' => "user address does not exist with id: $id", 'action' => 'removeUserAddres'];
    }

    if (!$user_address->user_id) {
      return ['ok' => false, 'message' => 'this user address does not belong to anyone, you can not perform delete on this object', 'action' => 'removeUserAddres'];
    }

    if ($user_address->user_id != $user->id) {
      return ['ok' => false, 'message' => "user address does not belong to you, you can not delete this object $user_address->user_id, $user->id", 'action' => 'removeUserAddres'];
    }

    $user_address->delete();
    return ['ok' => true, 'message' => 'user address successfully deleted', 'id' => $user_address->id, 'action' => 'removeUserAddres'];
  }

  public function actionCheckout()
  {
    $model = new OrderForm();
    $cart = Cart::getOrCreateCurrentInstance();
    $cartitems = $cart->cartItems;
    $user = Yii::$app->user->identity;

    if ($this->request->isPost && $model->load($this->request->post())) {
      $order = new Order();

      if ($model->selectedAddressId) {
        $address = UserAddress::findOne($model->selectedAddressId);
        if (!$address) {
          Yii::$app->session->setFlash('error', 'Selected address not found.');
          return $this->render('checkout', ['cart' => $cart, 'cartitems' => $cartitems, 'model' => $model]);
        }
      } else {
        $address = new UserAddress();
        $address->city = $model->city;
        $address->zip_code = $model->postalCode;
        $address->street_address = $model->streetAddress;
        $address->apartment = $model->apartment;
        $address->label = $model->city;
        $address->user_id = $user ? $user->id : null;
        $address->user_first_name = $model->firstName;
        $address->user_last_name = $model->lastName;
        $address->user_phone_number = $model->phoneNumber;

        if (!$address->save()) {
          Yii::$app->session->setFlash('error', 'Failed to save address.');
          return $this->render('checkout', ['cart' => $cart, 'cartitems' => $cartitems, 'model' => $model]);
        }
      }

      $order->delivery_type = $model->deliveryOption;
      $order->delivery_point_id = $model->submitPoint;
      $order->comment_for_courier = $model->commentForCourier;
      $order->payment_type = $model->paymentType;
      $order->address_id = $address->id;
      $order->status = Order::STATUS_PENDING;
      $order->user_id = $user ? $user->id : null;

      if (!$order->save()) {
        Yii::$app->session->setFlash('error', 'Failed to save order.');
        return $this->render('checkout', ['cart' => $cart, 'cartitems' => $cartitems, 'model' => $model]);
      }

      $order->linkAll('cartItems', $cart->cartItems, CartItem::class);
      $order->coupon_id = $cart->coupon ? $cart->coupon->id : null;
      $order->save();

      CartItem::updateAll(['cart_id' => null], ['cart_id' => $cart->id]);

      return $this->render('thank-you');
    }

    return $this->render('checkout', ['cart' => $cart, 'cartitems' => $cartitems, 'model' => $model]);
  }


  public function actionApplyCoupon()
  {
    $couponCode = $this->request->getBodyParam('coupon');
    $cart = Cart::getOrCreateCurrentInstance();
    $this->response->format = Response::FORMAT_JSON;

    if (!$couponCode) {
      return ['ok' => false, 'data' => "coupon: this field is required", "errorType" => "BadRequest", 'errorCode' => 'RequiredFieldEmpty', 'action' => 'applyCoupon'];
    }

    $coupon = Coupon::findOne(['code' => $couponCode]);
    if (!$coupon) {
      return ['ok' => false, 'data' => "coupon not found with code: $couponCode", "errorType" => "BadRequest", 'errorCode' => 'NotFound', 'action' => 'applyCoupon'];
    }

    $cart->coupon_id = $coupon->id;
    $cart->save();

    return ['data' => 'coupon applied successfully', 'ok' => true, 'action' => 'applyCoupon', 'cartGrandTotal' => $cart->totalPriceAsCurrency(), 'cartTotal' => $cart->totalPriceAsCurrency(), 'couponDiscountAmount' => $cart->couponDiscountAmount(), 'couponDiscountAmountAsCurrency' => $cart->couponDiscountAmountAsCurrency(), 'coupon' => $coupon];
  }

  public function actionError()
  {
    $exception = Yii::$app->errorHandler->exception;
    /*Utils::printAsError($exception->statusCode);*/
    if ($exception !== null && $exception->statusCode == 404) {
      return $this->render('404');
    } else {
      return  $this->render('400');
    }
  }

  public function actionVerifyAccessToken($accesstoken)
  {
    /** @var User $user */
    $user = User::findIdentityByaccesstoken($accesstoken);


    if ($user) {
      # check if the user is guest
      if (Yii::$app->user->isGuest) {
        # if user is guest, log him in
        Yii::$app->user->login($user, Utils::daysInSeconds(30));
      }
      # user is not guest, and has already logged in, so check if the user is active
      elseif ($user->is_active) {
        # user is logged in, and he is already active, there is no point for him to be here
        # rotate the keys and redirect to home page
        $user->setaccesstoken();
        $this->goHome();
      }

      $user->is_active = true;

      # rotate the access token
      $user->setaccesstoken();

      # save the user
      $user->save();
      return $this->renderPartial('access-verified', ['verified' => true]);
    }

    return $this->renderPartial('access-verified', ['verified' => false]);
  }
}
