<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "main_cart".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $user_id
 *
 * @property CartItem[] $mainCartitems
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
            [["user_id"], "required"],
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