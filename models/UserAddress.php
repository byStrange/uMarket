<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "main_useraddress".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $label
 * @property string $city
 * @property string $zip_code
 * @property int|null $delivery_point_id
 * @property int $user_id
 *
 * @property DeliveryPoint $deliveryPoint
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
            [["city", "zip_code", "user_id"], "required"],
            [["created_at", "updated_at"], "safe"],
            [["delivery_point_id", "user_id"], "default", "value" => null],
            [["delivery_point_id", "user_id"], "integer"],
            [["label", "city"], "string", "max" => 255],
            [["zip_code"], "string", "max" => 12],
            [
                ["delivery_point_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => DeliveryPoint::class,
                "targetAttribute" => ["delivery_point_id" => "id"],
            ],
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
     * Gets query for [[DeliveryPoint]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryPoint()
    {
        return $this->hasOne(DeliveryPoint::class, [
            "id" => "delivery_point_id",
        ]);
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
}
