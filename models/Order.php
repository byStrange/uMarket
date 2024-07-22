<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "main_order".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property string $payment_type
 * @property int|null $coupon_id
 * @property int $user_id
 * @property int|null $address_id
 *
 * @property UserAddress $address
 * @property CartItem[] $cartitems
 * @property Coupon $coupon
 * @property MainUser $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status', 'payment_type', 'user_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupon_id', 'user_id', 'address_id'], 'default', 'value' => null],
            [['coupon_id', 'user_id', 'address_id'], 'integer'],
            [['status', 'payment_type'], 'string', 'max' => 20],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coupon::class, 'targetAttribute' => ['coupon_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAddress::class, 'targetAttribute' => ['address_id' => 'id']],
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
            'status' => 'Status',
            'payment_type' => 'Payment Type',
            'coupon_id' => 'Coupon ID',
            'user_id' => 'User ID',
            'address_id' => 'Address ID',
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
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(UserAddress::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Cartitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['id' => 'cartitem_id'])->viaTable('main_order_order_items', ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Coupon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::class, ['id' => 'coupon_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
