<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_locationpoint".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property float|null $lon
 * @property float|null $lat
 * @property string|null $address_label
 *
 * @property DeliveryPoint $mainDeliverypoint
 */
class LocationPoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_locationpoint";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["created_at", "updated_at"], "safe"],
            [["lon", "lat"], "number"],
            [["lon", "lat"], "required"],
            [["address_label"], "string", "max" => 255],
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
            "lon" => "Lon",
            "lat" => "Lat",
            "address_label" => "Address Label",
        ];
    }

    public function behaviors()
    {
        return [
            [
                "class" => TimestampBehavior::class,
                "value" => new Expression("NOW()"),
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
        return $this->hasOne(DeliveryPoint::class, ["location_id" => "id"]);
    }

    public static function toOptionsList()
    {
        return ArrayHelper::map(
            self::find()
                ->select(["address_label", "id"])
                ->all(),
            "id",
            function ($model) {
                return (string) $model;
            }
        );
    }

    public function __toString()
    {
        return $this->address_label;
    }
}
