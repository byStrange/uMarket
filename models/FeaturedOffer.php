<?php

namespace app\models;

use app\components\Utils;
use DateTime;
use DateTimeZone;
use ParagonIE\Sodium\Core\Util;
use PhpOffice\PhpSpreadsheet\Shared\TimeZone;
use PhpParser\Node\Stmt\Continue_;
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
 * @property float $discount
 * @property string $start_time
 * @property string $end_time
 * @property string $price_type
 * @property int $product_id
 * @property int|null $category_id
 * @property string|null $image_banner
 * @property string|null $image_portrait
 * @property string|null $image_small_landscape
 * @property string $type
 * @property string $title
 *
 * @property Product[] $products
 * @property Category $category
 * @property Product $product
 */
class FeaturedOffer extends \yii\db\ActiveRecord
{
  const TYPE_PRODUCT = "product";
  const TYPE_CATEGORY = "category";
  const INCONSISTY_INACTIVE_PRODUCT_INCLUDED = 'inactive_product_included';
  const INCONSISTY_DUPLICATE_OFFER_FOR_A_PRODUCT = 'duplicate_offer_for_a_product';

  const PRICE_TYPE_PERCENTAGE = 'percentage';
  const PRICE_TYPE_AMOUNT = 'amount';
  const PRICE_TYPE_FIXED = 'fixed';

  public $image_banner_file;
  public $image_portrait_file;
  public $image_small_landscape_file;

  public static function priceTypesToOptionList()
  {
    return [
      self::PRICE_TYPE_FIXED => Yii::t('app', 'Fixed'),
      self::PRICE_TYPE_AMOUNT => Yii::t('app', 'Amount'),
      self::PRICE_TYPE_PERCENTAGE => Yii::t('app', 'Percentage'),
    ];
  }
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
      [["type", "title", "discount", "price_type"], "required"],
      [["category_id"], "required", "when" => function ($model) {
        return $model->type === 'category';
      }, "whenClient" => "function(attribute, value) { return $('[name=\"FeaturedOffer[type]\"]:checked').val() === 'category' }"],
      [["created_at", "updated_at", "start_time", "end_time"], "safe"],
      [["discount"], "number"],
      [["category_id"], "default", "value" => null],
      [["category_id"], "integer"],
      [
        ["image_banner", "image_small_landscape", "image_portrait"],
        "file",
        "skipOnEmpty" => true,
      ],
      [["type", "title", "price_type"], "string", "max" => 255],
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
      "discount" => "Discount Price",
      "start_time" => "Start Time",
      "end_time" => "End Time",
      "category_id" => "Category ID",
      "image_banner" => "Image Banner",
      "image_portrait" => "Image Portrait",
      "image_small_landscape" => "Image Small Landscape",
      "type" => "Type",
      "title" => "Title",
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
        "label" => Yii::t('app', "Category"),
        "value" => self::TYPE_CATEGORY,
        "description" =>
        Yii::t('app', "Include category that will be featured (all the products inside that category will be included automatically)"),
      ],
      self::TYPE_PRODUCT => [
        "label" => Yii::t('app',  "Product"),
        "value" => self::TYPE_PRODUCT,
        "description" =>
        Yii::t('app', "Include single product that will be featured (only the selected product will be included)"),
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


  public function getProducts()
  {
    return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('main_featuredoffer_main_products', ['featured_offer_id' => 'id']);
  }

  /**
   * Gets query for [[Product]].
   *
   * @return \yii\db\ActiveQuery
   */


  public function upload()
  {
    $uploadedBannerPath = Utils::uploadImage($this->image_banner_file);
    if ($uploadedBannerPath) {
      $this->image_banner = $uploadedBannerPath;
    }

    $uploadedSmallLandscapePath = Utils::uploadImage($this->image_small_landscape_file);
    if ($uploadedSmallLandscapePath) {
      $this->image_small_landscape = $uploadedSmallLandscapePath;
    }

    $uploadedPortraitPath = Utils::uploadImage($this->image_portrait_file);
    if ($uploadedPortraitPath) {
      $this->image_portrait = $uploadedPortraitPath;
    }

    return true;
  }

  public function linkAll($relation, $ids_list, $relation_model)
  {
    if (!is_array($ids_list)) {
      return;
    }
    foreach ($ids_list as $id) {
      if ($id) {
        $this->link($relation, $relation_model::findOne(["id" => $id]));
      }
    }
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function startingFromPrice(): int | float | null
  {
    if (!$this->products || count($this->products) === 0) return null;

    $minPriceProduct = PHP_INT_MAX;

    foreach ($this->products as $product) {
      $price = $product->cleanPrice();

      if ($price === null) continue;

      if ($price < $minPriceProduct) {
        $minPriceProduct = $price;
      }
    }

    return $minPriceProduct == PHP_INT_MAX ? null : $minPriceProduct;
  }

  public function startingFromPriceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->startingFromPrice());
  }

  public function discountPriceAsCurrency()
  {
    if ($this->discount) return Yii::$app->formatter->asCurrency($this->discount);

    if ($this->category) {
      return $this->category->startingFromPriceAsCurrency();
    } else if ($this->products) {
      if (count($this->products) === 1) {
        return $this->getProducts()->one()->priceAsCurrency();
      } else {
        return $this->startingFromPriceAsCurrency();
      }
    }
    return 0 . '$';
  }

  public function isActive()
  {

    $currentTime = new \DateTime('now', new \DateTimeZone('UTC')); // Get the current time


    $startTime = $this->start_time ? new \DateTime($this->start_time) : null;

    $endTime = $this->end_time ? new \DateTime($this->end_time) : null;
    // If neither start_time nor end_time is set, consider it always active
    if (!$startTime && !$endTime) {
      return true;
    }


    // If only start_time is set, it's active if the current time is after the start time
    if ($startTime && !$endTime) {
      return $currentTime >= $startTime;
    }


    // If only end_time is set, it's active if the current time is before the end time
    if (!$startTime && $endTime) {
      return $currentTime <= $endTime;
    }


    // If both start_time and end_time are set, it's active if the current time is between the two
    if ($startTime && $endTime) {
      return $currentTime >= $startTime && $currentTime <= $endTime;
    }

    return false; // Fallback, in case something unexpected happens
  }


  public static function activeOffers(bool $onlyExpression = false)
  {
    $now = new Expression('NOW()');
    $condition = [
      'or',
      ['and', ['IS NOT', 'start_time', null], ['IS NOT', 'end_time', null], ['<=', 'start_time', $now], ['>=', 'end_time', $now]],
      ['and', ['IS', 'start_time', null], ['IS', 'end_time', null]],
      ['and', ['IS', 'start_time', null], ['>=', 'end_time', $now]],
      ['and', ['<=', 'start_time', $now], ['IS', 'end_time', null]]
    ];

    if ($onlyExpression) return $condition;

    return self::find()
      ->where($condition);
  }


  public function offerOffset()
  {
    // Get the current time in UTC
    $currentTimestamp = time(); // You can use time() as it's already in UTC

    // Ensure end_time is a valid timestamp
    $endTimestamp = is_numeric($this->end_time) ? (int)$this->end_time : strtotime($this->end_time);

    // Check if current time is greater than end_time
    if ($currentTimestamp > $endTimestamp) {
      throw new \Exception('Current time cannot be greater than end time.');
    }

    // Calculate the difference in seconds
    $differenceInSeconds = $endTimestamp - $currentTimestamp;

    // Convert the difference to hours, minutes, and seconds
    $hours = floor($differenceInSeconds / 3600);
    $minutes = floor(($differenceInSeconds % 3600) / 60);
    $seconds = $differenceInSeconds % 60;

    // Format the result as "hours:min:sec"
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
  }
  public function timeOffset()
  {

    // Ensure start_time and end_time are valid timestamps
    $startTimestamp = is_numeric($this->start_time) ? (int)$this->start_time : strtotime($this->start_time);
    $endTimestamp = is_numeric($this->end_time) ? (int)$this->end_time : strtotime($this->end_time);

    // Check if start_time is greater than end_time
    if ($startTimestamp > $endTimestamp) {
      throw new \Exception('Start time cannot be greater than end time.');
    }

    // Calculate the difference in seconds
    $differenceInSeconds = $endTimestamp - $startTimestamp;

    // Convert the difference to hours, minutes, and seconds
    $hours = floor($differenceInSeconds / 3600);
    $minutes = floor(($differenceInSeconds % 3600) / 60);
    $seconds = $differenceInSeconds % 60;

    // Format the result as "hours:min:sec"
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
  }

  static public function _inconsisties()
  {
    $offers = FeaturedOffer::activeOffers()->all();
    $inconsistent_products = [];
    $inconsisties = [];
    foreach ($offers as $offer) {

      if ($offer->type === 'product' && $offer->products && count($offer->products)) {
        foreach ($offer->products as $product) {
          if (!in_array($product->status, Product::VISIBLE_STATUSES)) {
            $inconsistent_products[] = $product;
          }
        }
      }





      if (count($inconsistent_products)) {
        $inconsisties[] = [
          'data' =>  $inconsistent_products,
          'class' => FeaturedOffer::class,
          'dataClass' => Product::class,
          'list' => true,
          'type' => self::INCONSISTY_INACTIVE_PRODUCT_INCLUDED
        ];
      }

      $conflictingProducts = Yii::$app->db->createCommand("
    SELECT product_id, COUNT(product_id) 
FROM main_featuredoffer_main_products
GROUP BY product_id
HAVING COUNT (product_id) > 1

")->queryAll();
      $conflictingProductsIdsList = [];
      if (count($conflictingProducts)) {
        foreach ($conflictingProducts as $conflict) {
          $conflictingProductsIdsList[] = $conflict['product_id'];
        }
      }
      $conflictingProducts = Product::find()->where(['id' => $conflictingProductsIdsList])->all();

      if (count($conflictingProducts)) {
        $inconsisties[] = [
          'data' => $conflictingProducts,
          'class' => FeaturedOffer::class,
          'dataClass' => Product::class,
          'list' => true,
          'type' => self::INCONSISTY_DUPLICATE_OFFER_FOR_A_PRODUCT
        ];
      }
    }
    return $inconsisties;
  }

  public function __toString()
  {
    return $this->title;
  }
}
