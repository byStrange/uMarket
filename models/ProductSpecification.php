<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "main_product_specification".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $spec_key
 * @property string|null $spec_value
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MainProduct $product
 */
class ProductSpecification extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'main_product_specification';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['product_id'], 'default', 'value' => null],
      [['product_id'], 'integer'],
      [['created_at', 'updated_at'], 'safe'],
      [['spec_key', 'spec_value'], 'string', 'max' => 255],
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
      'product_id' => 'Product ID',
      'spec_key' => 'Spec Key',
      'spec_value' => 'Spec Value',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
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
