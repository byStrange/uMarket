<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_useraddress".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $label
 * @property string $city
 * @property string $street_address
 * @property string $apartment
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $user_phone_number
 * @property string $zip_code
 * @property int $user_id
 *
 * @property Order[] $mainOrders
 * @property User $user
 */
class UserAddress extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_useraddress";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["city", "zip_code", "user_first_name", "apartment", "street_address"], "required"],
      [["created_at", "updated_at"], "safe"],
      [["user_id"], "default", "value" => null],
      [["user_first_name", "user_last_name", "user_phone_number"], "string", "max" => 255],
      [["user_id"], "integer"],
      [["label", "city", "apartment", "street_address"], "string", "max" => 255],
      [["zip_code"], "string", "max" => 12],
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
      "label" => "Label",
      "city" => "City",
      "zip_code" => "Zip Code",
      "delivery_point_id" => "Delivery Point ID",
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
   * Gets query for [[Orders]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders()
  {
    return $this->hasMany(Order::class, ["address_id" => "id"]);
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

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["user_id", "label", "id"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function __toString()
  {
    return (string) $this->user . " : " . $this->label;
  }
}
