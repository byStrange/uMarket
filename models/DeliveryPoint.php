<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "main_deliverypoint".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $label
 * @property int $location_id
 *
 * @property LocationPoint $location
 * @property UserAddress[] $mainUseraddresses
 */
class DeliveryPoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_deliverypoint";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["location_id"], "required"],
            [["created_at", "updated_at"], "safe"],
            [["location_id"], "default", "value" => null],
            [["location_id"], "integer"],
            [["label"], "string", "max" => 255],
            [["location_id"], "unique"],
            [
                ["location_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => LocationPoint::class,
                "targetAttribute" => ["location_id" => "id"],
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
            "location_id" => "Location ID",
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
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(LocationPoint::class, ["id" => "location_id"]);
    }

    /**
     * Gets query for [[UserAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::class, [
            "delivery_point_id" => "id",
        ]);
    }
}
