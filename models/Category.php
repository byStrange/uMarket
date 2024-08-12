<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_category".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $parent_id
 * @property string $type
 * @property string $label
 * @property string $is_pinned
 *
 * @property Category[] $categories
 * @property CategoryTranslation[] $translations
 * @property ProductCategories[] $productCategories
 * @property Category $parentId
 * @property Product[] $products
 * @property FeaturedOffer $featuredOffer
 */
class Category extends \yii\db\ActiveRecord
{
  const TYPE_NORMAL = "normal";
  const TYPE_OFFER = "offer";

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_category";
  }

  public static function getTypeOptions()
  {
    return [
      self::TYPE_NORMAL => [
        "label" => Yii::t('app', "Normal"),
        "value" => self::TYPE_NORMAL,
        "description" => Yii::t('app', "For tagging normal products"),
      ],
      self::TYPE_OFFER => [
        "label" => Yii::t('app', "Offer"),
        "description" => Yii::t('app', "Used to tag products for featured offers"),
        "value" => self::TYPE_OFFER,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["label", "type"], "required"],
      [["created_at", "updated_at"], "safe"],
      [["parent_id"], "default", "value" => null],
      [["label", "type"], "string", "max" => 255],
      [["parent_id"], "integer"],
      [["is_pinned"], "boolean"],
      [
        ["parent_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => Category::class,
        "targetAttribute" => ["parent_id" => "id"],
      ],
      ["type", "in", "range" => [self::TYPE_NORMAL, self::TYPE_OFFER]],
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
      "parent_id" => "Parent Id ID",
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
   * Gets query for [[Categories]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCategories()
  {
    return $this->hasMany(Category::class, ["parent_id" => "id"]);
  }

  /**
   * Gets query for [[CategoryTranslations]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getTranslations()
  {
    return $this->hasMany(CategoryTranslation::class, [
      "category_id" => "id",
    ]);
  }

  public function getCategoryTranslationForLanguage($lang = '')
  {
    $category = CategoryTranslation::findOne([
      "category_id" => $this->id,
      "language_code" => $lang ? $lang : Yii::$app->language,
    ]);
    $empty = new CategoryTranslation([]);
    return $category ? $category : $empty;
  }

  /**
   * Gets query for [[ParentId]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getParentId()
  {
    return $this->hasOne(Category::class, ["id" => "parent_id"]);
  }

  /**
   * Gets query for [[Products]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProducts()
  {
    return $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(
      "main_product_categories",
      ["category_id" => "id"]
    );
  }

  public function getFeaturedOffer()
  {
    return $this->hasOne(FeaturedOffer::class, ['id' => 'category_id']);
  }

  public function startingFromPrice()
  {
    $product = $this->getProducts()->orderBy(['price' => SORT_ASC, 'discount_price' => SORT_ASC])->limit(1)->one();

    if ($product) return $product->cleanPrice();

    return 0;
  }

  public function startingFromPriceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->startingFromPrice());
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["id", "label"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function __toString()
  {
    $translation = $this->getCategoryTranslationForLanguage();
    $valid = $translation ? $translation->name : $this->label;
    return $valid ? $valid : $this->id;
  }
}
