<?php

namespace app\models;

use app\components\Utils;
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
 * @property string $start_date
 * @property string $end_date
 * @property string $code
 * @property int $discount_percentage
 * @property int $discount_price
 * @property bool $is_active
 * @property string $label
 *
 * @property Order[] $orders
 */
class Coupon extends \yii\db\ActiveRecord
{
  public $type;
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
      [["code", "is_active", 'start_date', 'end_date'], "required"],
      [["created_at", "updated_at"], "safe"],
      [["discount_percentage"], "integer"],
      [["discount_price"], "integer"],
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
    return ArrayHelper::map(
      self::find()
        ->select(["label", "discount_percentage", "id"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function isActive()
  {
    if (!$this->is_active) {
      return false;
    }

    $now = new \DateTime();
    $startDate = new \DateTime($this->start_date);

    $endDate = new \DateTime($this->end_date);

    return $startDate <= $now && $endDate >= $now;
  }

  public static function findActive()
  {
    $currentDateTime = date('Y-m-d H:i:s'); // Get current datetime
    return self::find()
      ->andWhere(['is_active' => true])
      ->andWhere(['<=', 'start_date', $currentDateTime])
      ->andWhere(['>=', 'end_date', $currentDateTime]);
  }

  public function discountPriceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->discount_price);
  }

  public function discountDisplay()
  {
    return $this->discount_percentage ? $this->discount_percentage . '%' : $this->discountPriceAsCurrency();
  }

  public function __toString()
  {
    return $this->label . " - " . $this->discountDisplay();
  }
}
