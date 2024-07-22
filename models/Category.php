<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "main_category".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $parent_id_id
 *
 * @property Category[] $categories
 * @property CategoryTranslation[] $mainCategorytranslations
 * @property ProductCategories[] $mainProductCategories
 * @property Category $parentId
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'parent_id_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_id_id'], 'default', 'value' => null],
            [['parent_id_id'], 'integer'],
            [['parent_id_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id_id' => 'id']],
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
            'parent_id_id' => 'Parent Id ID',
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
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['parent_id_id' => 'id']);
    }

    /**
     * Gets query for [[CategoryTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTranslations()
    {
        return $this->hasMany(CategoryTranslation::class, ['category_id' => 'id']);
    }

     /**
     * Gets query for [[ParentId]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentId()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('main_product_categories', ['category_id' => 'id']);
    }
}
