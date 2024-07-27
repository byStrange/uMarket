<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "main_featuredoffer".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property float $dicount_price
 * @property string $start_time
 * @property string $end_time
 * @property int $product_id
 * @property int|null $category_id
 * @property int|null $image_banner_id
 * @property int|null $image_portrait_id
 * @property int|null $image_small_landscape_id
 * @property string $type
 *
 * @property Category $category
 * @property Image $imageBanner
 * @property Image $imagePortrait
 * @property Image $imageSmallLandscape
 * @property Product $product
 */
class FeaturedOffer extends \yii\db\ActiveRecord
{
  const TYPE_PRODUCT = 'product';
  const TYPE_CATEGORY = 'category';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_featuredoffer";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    "dicount_price",
                    "start_time",
                    "end_time",
                    "type",
                ],
                "required",
            ],
            [["created_at", "updated_at", "start_time", "end_time"], "safe"],
            [["dicount_price"], "number"],
            [
                [
                    "product_id",
                    "category_id",
                    "image_banner_id",
                    "image_portrait_id",
                    "image_small_landscape_id",
                ],
                "default",
                "value" => null,
            ],
            [
                [
                    "product_id",
                    "category_id",
                    "image_banner_id",
                    "image_portrait_id",
                    "image_small_landscape_id",
                ],
                "integer",
            ],
            [["type"], "string", "max" => 255],
            [["type"], 'in', "range" => [self::TYPE_CATEGORY, self::TYPE_PRODUCT]],
            [
                ["category_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Category::class,
                "targetAttribute" => ["category_id" => "id"],
            ],
            [
                ["image_banner_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Image::class,
                "targetAttribute" => ["image_banner_id" => "id"],
            ],
            [
                ["image_portrait_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Image::class,
                "targetAttribute" => ["image_portrait_id" => "id"],
            ],
            [
                ["image_small_landscape_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Image::class,
                "targetAttribute" => ["image_small_landscape_id" => "id"],
            ],
            [
                ["product_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Product::class,
                "targetAttribute" => ["product_id" => "id"],
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
            "dicount_price" => "Dicount Price",
            "start_time" => "Start Time",
            "end_time" => "End Time",
            "product_id" => "Product ID",
            "category_id" => "Category ID",
            "image_banner_id" => "Image Banner ID",
            "image_portrait_id" => "Image Portrait ID",
            "image_small_landscape_id" => "Image Small Landscape ID",
            "type" => "Type",
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

    public static function getTypeOptions() {

      return [
        self::TYPE_CATEGORY => [
          "label" => 'Category',
          "value" => self::TYPE_CATEGORY,
          "description" => 'Include category that will be featured (all the products inside that category will be included automatically)'
        ],
        self::TYPE_PRODUCT => [
          "label" => "Product",
          "value" => self::TYPE_PRODUCT,
          "description" => 'Include single product that will be featured (only the selected product will be included)'
        ]
      ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ["id" => "category_id"]);
    }

    /**
     * Gets query for [[ImageBanner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageBanner()
    {
        return $this->hasOne(Image::class, ["id" => "image_banner_id"]);
    }

    /**
     * Gets query for [[ImagePortrait]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagePortrait()
    {
        return $this->hasOne(Image::class, ["id" => "image_portrait_id"]);
    }

    /**
     * Gets query for [[ImageSmallLandscape]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageSmallLandscape()
    {
        return $this->hasOne(Image::class, [
            "id" => "image_small_landscape_id",
        ]);
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
}
