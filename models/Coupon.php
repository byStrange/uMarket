<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_coupon".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $code
 * @property int $discount_percentage
 * @property bool $is_active
 * @property string $label
 *
 * @property Order[] $orders
 */
class Coupon extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_coupon";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [
        [
          "code",
          "discount_percentage",
          "is_active",
        ],
        "required",
      ],
      [["created_at", "updated_at"], "safe"],
      [["discount_percentage"], "default", "value" => null],
      [["discount_percentage"], "integer"],
      [["is_active"], "boolean"],
      [["code"], "string", "max" => 10],
      [["label"], "string", "max" => 255],
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
      "code" => "Code",
      "discount_percentage" => "Discount Percentage",
      "is_active" => "Is Active",
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
   * Gets query for [[Orders]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders()
  {
    return $this->hasMany(Order::class, ["coupon_id" => "id"]);
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(self::find()->select(['label', 'discount_percentage', 'id'])->all(), 'id', function ($model) {
      return (string)($model);
    });
  }

  public function __toString()
  {
    return $this->label . ' - ' . $this->discount_percentage;
  }
}
