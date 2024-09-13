<?php

namespace app\models;

use app\components\Utils;
use ParagonIE\Sodium\Core\Util;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "main_categorytranslation".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $language_code
 * @property string $name
 * @property int $category_id
 * @property string $image
 *
 * @property UploadedFile $image_file
 *
 * @property Category $category
 * @property Image $image
 */
class CategoryTranslation extends \yii\db\ActiveRecord
{
  public $image_file;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "categorytranslation";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["language_code", "name", "category_id", "image"], "required"],
      [["created_at", "updated_at"], "safe"],
      [["category_id"], "default", "value" => null],
      [["category_id"], "integer"],
      [["language_code"], "string", "max" => 10],
      [["name"], "string", "max" => 255],
      [['image'], "file", "skipOnEmpty" => true],
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
      "language_code" => "Language Code",
      "name" => "Name",
      "category_id" => "Category ID",
      "image" => "Image",
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

  public function getCategory()
  {
    return $this->hasOne(Category::class, ["id" => "category_id"]);
  }

  public function upload()
  {
    if (!$this->image_file) return;
    $path = Utils::uploadImage($this->image_file);
    $this->image = $path;
  }
}
