<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "main_categorytranslation".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $language_code
 * @property string $name
 * @property int $category_id
 * @property int $image_id
 *
 * @property Category $category
 * @property Image $image
 */
class CategoryTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_categorytranslation";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["language_code", "name", "category_id", "image_id"], "required"],
            [["created_at", "updated_at"], "safe"],
            [["category_id", "image_id"], "default", "value" => null],
            [["category_id", "image_id"], "integer"],
            [["language_code"], "string", "max" => 10],
            [["name"], "string", "max" => 255],
            [["image_id"], "unique"],
            [
                ["category_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Category::class,
                "targetAttribute" => ["category_id" => "id"],
            ],
            [
                ["image_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Image::class,
                "targetAttribute" => ["image_id" => "id"],
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
            "image_id" => "Image ID",
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

    public function getImage()
    {
        return $this->hasOne(Image::class, ["id" => "image_id"]);
    }
}
