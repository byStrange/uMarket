<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "main_producttranslation".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $language_code
 * @property string $title
 * @property int $product_id
 *
 * @property MainProduct $product
 */
class ProductTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_producttranslation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_code', 'title', 'product_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_id'], 'default', 'value' => null],
            [['product_id'], 'integer'],
            [['language_code'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['product_id', 'language_code'], 'unique', 'targetAttribute' => ['product_id', 'language_code']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
            'language_code' => 'Language Code',
            'title' => 'Title',
            'product_id' => 'Product ID',
        ];
    }

    public function behaviors() {
        return [
          [
            'class' => TimestampBehavior::class,
            'value' => new Expression('NOW()')
          ],
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
