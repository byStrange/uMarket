<?php

namespace app\models;

use app\components\Utils;
use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Shared\TimeZone;
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
 * @property string $title
 *
 * @property Category $category
 * @property Product $product
 */
class FeaturedOffer extends \yii\db\ActiveRecord
{
  const TYPE_PRODUCT = "product";
  const TYPE_CATEGORY = "category";
  public $image_banner_file;
  public $image_portrait_file;
  public $image_small_landscape_file;
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
      [["type"], "required"],
      [["created_at", "updated_at", "start_time", "end_time"], "safe"],
      [["dicount_price"], "number"],
      [["product_id", "category_id"], "default", "value" => null],
      [["product_id", "category_id"], "integer"],
      [
        ["image_banner", "image_small_landscape", "image_portrait"],
        "file",
        "skipOnEmpty" => true,
      ],
      [["type", "title"], "string", "max" => 255],
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

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["id", "product_id"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function discountPriceAsCurrency()
  {
    if ($this->dicount_price) return Yii::$app->formatter->asCurrency($this->dicount_price);

    if ($this->category) {
      return $this->category->startingFromPriceAsCurrency();
    } else if ($this->product) {
      return $this->product->priceAsCurrency();
    }

    return 0 . '$';
  }

  public function isActive()
  {

    $currentTime = new \DateTime(); // Get the current time

    $asiaTimeZone = new DateTimeZone('Asia/Samarkand');

    $_startTime = $this->start_time ? new \DateTime($this->start_time) : null;
    $startTime = new DateTime($_startTime->format('Y-m-d H:i:s'), $asiaTimeZone);

    $_endTime = $this->end_time ? new \DateTime($this->end_time) : null;
    $endTime = new DateTime($_endTime->format('Y-m-d H:i:s'), $asiaTimeZone);


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

  public static function activeOffers()
  {
    $now = new Expression('NOW()');

    return self::find()
      ->where([
        'or',
        ['and', ['IS NOT', 'start_time', null], ['IS NOT', 'end_time', null], ['<=', 'start_time', $now], ['>=', 'end_time', $now]],
        ['and', ['IS', 'start_time', null], ['IS', 'end_time', null]],
        ['and', ['IS', 'start_time', null], ['>=', 'end_time', $now]],
        ['and', ['<=', 'start_time', $now], ['IS', 'end_time', null]]
      ]);
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

  public function __toString()
  {
    return "Offered " . (string) $this->product;
  }
}
