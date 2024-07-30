<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "main_image".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property UploadedFile $image
 * @property string $alt
 *
 * @property MainCategorytranslation $mainCategorytranslation
 * @property User $mainUser
 * @property Product[] $products
 */
class Image extends \yii\db\ActiveRecord
{
  /**
   * @var UploadedFile $image */
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_image";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["image", "alt"], "required"],
      [["created_at", "updated_at"], "safe"],
      [["image"], "file", "skipOnEmpty" => false],
      [["alt"], "string", "max" => 255],
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
      "image" => "Image",
      "alt" => "Alt",
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
   * Gets query for [[MainCategorytranslation]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getMainCategorytranslation()
  {
    return $this->hasOne(CategoryTranslation::class, ["image_id" => "id"]);
  }

  /**
   * Gets query for [[Products]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProducts()
  {
    return $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(
      "main_product_images",
      ["image_id" => "id"]
    );
  }

  public function upload()
  {
    $filePath = Utils::uploadImage($this->image);
    $this->image = $filePath;
    return true;
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(self::find()->select(['id', 'image'])->all(), 'id', function ($model) {
      return (string)($model);
    });
  }

  public function __toString()
  {
    return $this->image;
  }
}
