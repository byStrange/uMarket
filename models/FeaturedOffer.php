<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
 * @property string|null $image_banner
 * @property string|null $image_portrait
 * @property string|null $image_small_landscape
 * @property string $type
 *
 * @property Category $category
 * @property Product $product
 */
class FeaturedOffer extends \yii\db\ActiveRecord
{
  const TYPE_PRODUCT = "product";
  const TYPE_CATEGORY = "category";
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
      [["dicount_price", "type"], "required"],
      [["created_at", "updated_at", "start_time", "end_time"], "safe"],
      [["dicount_price"], "number"],
      [
        [
          "product_id",
          "category_id",
        ],
        "default",
        "value" => null,
      ],
      [
        [
          "product_id",
          "category_id",
        ],
        "integer",
      ],
      [
        [
          "image_banner",
          "image_small_landscape",
          "image_portrait"
        ],
        "file",
        "skipOnEmpty" => true
      ],
      [["type"], "string", "max" => 255],
      [
        ["type"],
        "in",
        "range" => [self::TYPE_CATEGORY, self::TYPE_PRODUCT],
      ],
      [
        ["category_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => Category::class,
        "targetAttribute" => ["category_id" => "id"],
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
      "image_banner" => "Image Banner",
      "image_portrait" => "Image Portrait",
      "image_small_landscape" => "Image Small Landscape",
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

  public static function getTypeOptions()
  {
    return [
      self::TYPE_CATEGORY => [
        "label" => "Category",
        "value" => self::TYPE_CATEGORY,
        "description" =>
        "Include category that will be featured (all the products inside that category will be included automatically)",
      ],
      self::TYPE_PRODUCT => [
        "label" => "Product",
        "value" => self::TYPE_PRODUCT,
        "description" =>
        "Include single product that will be featured (only the selected product will be included)",
      ],
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
   * Gets query for [[Product]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProduct()
  {
    return $this->hasOne(Product::class, ["id" => "product_id"]);
  }

  public function upload()
  {
    Utils::uploadImage($this->image_banner);
    Utils::uploadImage($this->image_small_landscape);
    Utils::uploadImage($this->image_portrait);
    return true;
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(self::find()->select(['id', 'product_id'])->all(), 'id', function ($model) {
      return (string)($model);
    });
  }

  public function __toString()
  {
    return 'Offered ' . (string)$this->product;
  }
}
