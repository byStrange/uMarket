<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "main_product".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property float $price
 * @property float|null $discount_price
 * @property string $status
 * @property int $views
 * @property int $created_by_id
 *
 * @property Category[] $categories
 * @property User $createdBy
 * @property Product[] $fromProducts
 * @property Image[] $images
 * @property CartItem[] $mainCartitems
 * @property ProductCategories[] $mainProductCategories
 * @property ProductImages[] $mainProductImages
 * @property ProductLikes[] $mainProductLikes
 * @property ProductRelatedProducts[] $mainProductRelatedProducts
 * @property ProductRelatedProducts[] $mainProductRelatedProducts0
 * @property ProductViewer[] $mainProductViewers
 * @property ProductTranslation[] $mainProducttranslations
 * @property Product[] $toProducts
 * @property User[] $users
 * @property User[] $users0
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'price', 'status', 'views', 'created_by_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['price', 'discount_price'], 'number'],
            [['views', 'created_by_id'], 'default', 'value' => null],
            [['views', 'created_by_id'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['created_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by_id' => 'id']],
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
            'price' => 'Price',
            'discount_price' => 'Discount Price',
            'status' => 'Status',
            'views' => 'Views',
            'created_by_id' => 'Created By ID',
        ];
    }

     public function behaviors() {
        return [
          [
            'class' => TimestampBehavior::class,
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
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('main_product_categories', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by_id']);
    }

    /**
     * Gets query for [[FromProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'from_product_id'])->viaTable('main_product_related_products', ['to_product_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'image_id'])->viaTable('main_product_images', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    
    /**
     * Gets query for [[ToProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'to_product_id'])->viaTable('main_product_related_products', ['from_product_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikedUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('main_product_likes', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('main_product_viewers', ['product_id' => 'id']);
    }
}
