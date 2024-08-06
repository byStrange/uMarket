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
 * @property CartItem[] $cartitems
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
    $session = Yii::$app->session;
    $cart_id = $session->get('cart_id');
    if (!$cart_id && $auto_create) {
      $cart = new Cart();
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

  public function totalPrice()
  {
    $cartItems = $this->cartItems;
    $total = 0;
    foreach ($cartItems as $item) {
      $total = $total + $item->subTotal();
    }

    return $total;
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


  public function __toString()
  {
    return "cart " . (string)$this->user;
  }
}
