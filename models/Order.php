<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "main_order".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property string $payment_type
 * @property string $delivery_type
 * @property string $comment_for_courier
 *
 * @property int|null $coupon_id
 * @property int|null $user_id
 * @property int|null $address_id
 *
 * @property UserAddress $address
 * @property DeliveryPoint $deliveryPoint
 * @property CartItem[] $cartItems
 * @property Coupon $coupon
 * @property MainUser $user
 */
class Order extends \yii\db\ActiveRecord
{
  const STATUS_PENDING = 'pending';
  const STATUS_CONFIRMED = 'confirmed';
  const STATUS_SHIPPED = 'shipped';
  const STATUS_DELIVERED = 'delivered';
  const STATUS_CANCELED = 'canceled';
  const PAYMENT_TYPE_CASH = 'cash';
  const PAYMENT_TYPE_PAYME = 'payme';
  const PAYMENT_TYPE_CLICK = 'click';


  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_order";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["status", "payment_type"], "required"],
      [["created_at", "updated_at"], "safe"],
      [
        ["coupon_id", "user_id", "address_id"],
        "default",
        "value" => null,
      ],
      [["coupon_id", "user_id", "address_id"], "integer"],
      [["status", "payment_type"], "string", "max" => 20],
      [["delivery_type"], "string"],
      [
        ["delivery_point_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => DeliveryPoint::class,
        "targetAttribute" => ["delivery_point_id" => "id"],
      ],
      [
        ["coupon_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => Coupon::class,
        "targetAttribute" => ["coupon_id" => "id"],
      ],
      [
        ["user_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => User::class,
        "targetAttribute" => ["user_id" => "id"],
      ],
      [
        ["address_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => UserAddress::class,
        "targetAttribute" => ["address_id" => "id"],
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
      "status" => "Status",
      "payment_type" => "Payment Type",
      "coupon_id" => "Coupon ID",
      "user_id" => "User ID",
      "address_id" => "Address ID",
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
   * Gets query for [[Address]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAddress()
  {
    return $this->hasOne(UserAddress::class, ["id" => "address_id"]);
  }

  /**
   * Gets query for [[Cartitems]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCartItems()
  {
    return $this->hasMany(CartItem::class, [
      "id" => "cartitem_id",
    ])->viaTable("main_order_order_items", ["order_id" => "id"]);
  }

  /**
   * Gets query for [[Coupon]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCoupon()
  {
    return $this->hasOne(Coupon::class, ["id" => "coupon_id"]);
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

  public function getDeliveryPoint()
  {
    return $this->hasOne(DeliveryPoint::class, [
      "id" => "delivery_point_id",
    ]);
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
  public static function getPaymentTypeOptions()
  {
    return [
      self::PAYMENT_TYPE_CASH => 'Cash',
      self::PAYMENT_TYPE_CLICK => 'Click',
      self::PAYMENT_TYPE_PAYME => 'PayMe'
    ];
  }

  public function linkAll($relation, $ids_list, $relation_model)
  {
    if (!is_array($ids_list)) {
      return;
    }
    foreach ($ids_list as $id) {
      $this->link($relation, $relation_model::findOne(["id" => $id]));
    }
  }
}
