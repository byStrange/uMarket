<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_product".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property float $price
 * @property float|null $discount_price
 * @property string $status
 * @property int $views
 * @property int $created_by_id
 * @property int $average_rating
 * @property int $total_ratings
 *
 *
 * @property Category[] $categories
 * @property User $createdBy
 * @property Product[] $fromProducts
 * @property Image[] $images
 * @property CartItem[] $cartItems
 * @property Product[] $toProducts
 * @property User[] $likedUsers
 * @property User[] $viewers
 * @property Rating[] $ratings
 * @property ProductTranslation[] $translations
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_product";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["price", "status"], "required"],
            [["created_at", "updated_at"], "safe"],
            [
                ["price", "discount_price", "average_rating", "total_ratings"],
                "number",
            ],
            [["created_by_id"], "default", "value" => Yii::$app->user->id],
            [["views", "created_by_id"], "integer"],
            [["views"], "default", "value" => 0],
            [["status"], "string", "max" => 20],
            [
                ["created_by_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => User::class,
                "targetAttribute" => ["created_by_id" => "id"],
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
            "price" => "Price",
            "discount_price" => "Discount Price",
            "status" => "Status",
            "views" => "Views",
            "created_by_id" => "Created By ID",
        ];
    }

    public function behaviors()
    {
        return [
            [
                "class" => TimestampBehavior::class,
                "value" => new Expression("now()"),
            ],
        ];
    }

    public static function getMostFamous8()
    {
        return self::find()
            /*->select(['id', 'average_rating', 'total_ratings'])*/
            ->orderBy([
                "total_ratings" => SORT_DESC,
                "average_rating" => SORT_DESC,
            ])
            ->limit(8)
            ->all();
    }

    public function getTranslations()
    {
        return $this->hasMany(ProductTranslation::class, [
            "product_id" => "id",
        ]);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, [
            "id" => "category_id",
        ])->viaTable("main_product_categories", ["product_id" => "id"]);
    }

    public function getRatings()
    {
        return $this->hasMany(Rating::class, [
            "product_id" => "id",
        ]);
    }

    public function updateRatingStats()
    {
        $this->total_ratings = $this->getRatings()->count();
        $this->average_rating = $this->getRatings()->average("score");
        return $this->save(false);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->updateRatingStats();
        }
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ["id" => "created_by_id"]);
    }

    /**
     * Gets all the products in which this product was being used
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromProducts()
    {
        return $this->hasMany(Product::class, [
            "id" => "from_product_id",
        ])->viaTable("main_product_related_products", [
            "to_product_id" => "id",
        ]);
    }

    public function getProductTranslationForLanguage($lang = "")
    {
        return ProductTranslation::findOne([
            "product_id" => $this->id,
            "language_code" => $lang ? $lang : Yii::$app->language,
        ]);
    }

    public function getProductSalePercentage()
    {
        if ($this->discount_price > $this->price) {
            return false;
        }
        return $this->discount_price
            ? ($this->discount_price / $this->price) * 100 - 100
            : 0;
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ["id" => "image_id"])->viaTable(
            "main_product_images",
            ["product_id" => "id"]
        );
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ["product_id" => "id"]);
    }

    /**
     * Gets all related_products of the product
     *
     *
     * @return \yii\db\ActiveQuery
     */

    public function getToProducts()
    {
        return $this->hasMany(Product::class, [
            "id" => "to_product_id",
        ])->viaTable("main_product_related_products", [
            "from_product_id" => "id",
        ]);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikedUsers()
    {
        return $this->hasMany(User::class, ["id" => "user_id"])->viaTable(
            "main_product_likes",
            ["product_id" => "id"]
        );
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewers()
    {
        return $this->hasMany(User::class, ["id" => "user_id"])->viaTable(
            "main_product_viewers",
            ["product_id" => "id"]
        );
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

    public static function toOptionsList()
    {
        return ArrayHelper::map(
            Product::find()
                ->select(["created_by_id", "id"])
                ->all(),
            "id",
            function ($model) {
                return (string) $model;
            }
        );
    }

    public function __toString()
    {
        return $this->getProductTranslationForLanguage()
            ? $this->getProductTranslationForLanguage()->title
            : $this->createdBy->username . " -> " . $this->id;
    }
}
