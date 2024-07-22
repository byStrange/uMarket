<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "main_image".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 * @property string $alt
 *
 * @property MainCategorytranslation $mainCategorytranslation
 * @property User $mainUser
 * @property Product[] $products
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'image', 'alt'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'string', 'max' => 100],
            [['alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'image' => 'Image',
            'alt' => 'Alt',
        ];
    }

    public function behaviors() {
        return [
          [
            'class' => TimeStampBehavior::class,
            'value' => new Expression('now()')
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
        return $this->hasOne(CategoryTranslation::class, ['image_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['profile_picture_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('main_product_images', ['image_id' => 'id']);
    }
}
