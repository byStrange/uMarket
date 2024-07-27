<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "main_rating".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $score
 * @property string|null $comment
 * @property int $product_id
 * @property int $user_id
 *
 * @property Product $product
 * @property User $user
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_rating";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["score", "product_id", "user_id"], "required"],
            [["created_at", "updated_at"], "safe"],
            [["score", "product_id", "user_id"], "default", "value" => null],
            [["score", "product_id", "user_id"], "integer"],
            [["comment"], "string"],
            [
                ["product_id", "user_id"],
                "unique",
                "targetAttribute" => ["product_id", "user_id"],
            ],
            [
                ["product_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Product::class,
                "targetAttribute" => ["product_id" => "id"],
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
            "score" => "Score",
            "comment" => "Comment",
            "product_id" => "Product ID",
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
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ["id" => "product_id"]);
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
