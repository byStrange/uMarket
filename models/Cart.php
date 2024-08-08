<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_cart".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $user_id
 *
 *
 * @property CartItem[] $cartitems
 * @property Coupon $coupon
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_cart";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["created_at", "updated_at"], "safe"],
      [["user_id"], "default", "value" => null],
      [["user_id"], "integer"],
      [
        ["user_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => User::class,
        "targetAttribute" => ["user_id" => "id"],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      "id" => "ID",
      "created_at" => "Created At",
      "updated_at" => "Updated At",
      "user_id" => "User ID",
    ];
  }

  public function behaviors()
  {
    return [
      [
        "class" => TimeStampBehavior::class,
        "value" => new Expression("now()"),
      ],
    ];
  }

  /**
   * Gets query for [[CartItems]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCartItems()
  {
    return $this->hasMany(CartItem::class, ["cart_id" => "id"]);
  }

  public function getWishlistitems()
  {
    return $this->hasMany(Wishlistitem::class, ['cart_id' => 'id']);
  }

  public function afterDelete()
  {
    parent::afterDelete();
    Yii::$app->session->remove('cart_id');
  }

  public static function getOrCreateCurrentInstance($auto_create = true)
  {
    $user = Yii::$app->user->identity;
    if ($user && $user->cart) {
      return $user->cart;
    }

    $session = Yii::$app->session;
    $cart_id = $session->get('cart_id');
    if (!$cart_id && $auto_create) {
      $cart = new Cart();
      $cart->user_id = $user ? $user->id : null;
      $cart->save();
      $session->set('cart_id', $cart->id);
      return $cart;
    };

    $cart = self::findOne(['id' => $cart_id]);
    return $cart;
  }

  /**
   * Gets query for [[User]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::class, ["id" => "user_id"]);
  }

  public function couponDiscountAmount()
  {
    if (!$this->coupon) return 0;
    $total = $this->_rawTotalPrice();

    $coupon = $this->coupon;

    if ($coupon->discount_price) {
      return $coupon->discount_price;
    }

    if ($coupon->discount_percentage) {
      $discountAmount = ($total * $coupon->discount_percentage) / 100;
      return $discountAmount;
    }

    return 0;
  }

  public function _rawTotalPrice()
  {
    $cartItems = $this->cartItems;
    $total = 0;

    foreach ($cartItems as $item) {
      $total = $total + $item->subTotal();
    }

    return $total;
  }


  public function totalPrice()
  {
    $total = $this->_rawTotalPrice() - $this->couponDiscountAmount();

    return $total;
  }

  public function couponDiscountAmountAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->couponDiscountAmount());
  }

  public function totalPriceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->totalPrice());
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["user_id", "id"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function getCoupon()
  {
    return $this->hasOne(Coupon::class, ['id' => 'coupon_id']);
  }


  public function __toString()
  {
    return "cart " . (string)$this->user;
  }
}
